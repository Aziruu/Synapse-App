<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ExamSession;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\Answer;
use App\Models\BankSoal;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    // Khusus Siswa | Murid
    public function index(Request $request)
    {
        $user = $request->user();

        // Ambil ujian yang tersedia untuk kelas si User
        $exams = \App\Models\Exam::whereHas('classes', function($q) use ($user) {
            $q->whereIn('classes.id', $user->classes->pluck('id'));
        })->get();

        $data = $exams->map(function($exam) use ($user) {
            // Cari sesi terakhir User di ujian ini
            $session = \App\Models\ExamSession::where('exam_id', $exam->id)
                ->where('student_id', $user->id)
                ->first();

            return [
                'id' => $exam->id,
                'title' => $exam->title,
                'duration' => $exam->duration,
                'status' => $session ? $session->status : 'belum',
                'score' => $session ? $session->score : 0,
            ];
        });

        return response()->json($data);
    }

    // Masuk Ujian Pakai Token
    public function joinExam(Request $request)
    {
        $request->validate(['token' => 'required']);

        // 1. Cari Exam berdasarkan Token
        $exam = Exam::where('token', $request->token)->first();

        if (!$exam) {
            return response()->json(['message' => 'Maaf, Token MTK123 tidak ditemukan!'], 404);
        }

        // 2. KELONGGARAN WAKTU (Biar gak error jam)
        // Kita buat start_time lebih awal 10 menit buat jaga-jaga lag server
        $startTime = \Carbon\Carbon::parse($exam->start_time)->subMinutes(10);
        $endTime = \Carbon\Carbon::parse($exam->end_time);
        $now = now();

        if ($now->lt($startTime) || $now->gt($endTime)) {
            return response()->json([
                'message' => 'Ujian belum dimulai atau sudah lewat!',
                'server_time' => $now->toDateTimeString(),
                'exam_start' => $startTime->toDateTimeString()
            ], 403);
        }

        // 3. Buat Sesi
        $session = ExamSession::firstOrCreate([
            'exam_id' => $exam->id,
            'student_id' => \Illuminate\Support\Facades\Auth::id(),
        ], [
            'start_at' => $now,
            'status' => 'progress'
        ]);

        return response()->json([
            'status' => 'success',
            'exam' => $exam->load('soals'),
            'session_id' => $session->id
        ]);
    }

    //  Khusus Guru

    //  Cek Hasil Ujian
    public function report($exam_id)
    {
        $exam = Exam::with('sessions.user')->findOrFail($exam_id);

        if ($exam->guru_id !== Auth::id()) {
            return response()->json(['message' => 'Unauthorized'], 403);
        }

        return response()->json($exam);
    }

    public function submitAnswer(Request $request)
    {
        $request->validate([
            'session_id' => 'required|exists:exam_sessions,id',
            'soal_id'    => 'required|exists:bank_soals,id',
            'answer_text' => 'required',
        ]);

        $soal = BankSoal::findOrFail($request->soal_id);
        $studentAnswer = $request->answer_text;
        $isCorrect = false;
        $points = 0;

        // Logic Cek

        if ($soal->type === 'pg') {
            // 1. Pilihan Ganda: Cek string langsung
            if (strtolower($studentAnswer) === strtolower($soal->correct_answer)) {
                $isCorrect = true;
                $points = 10;
            }
        } else {
            // 2. Essay: Inovasi Synapse
            // A. Cek Toleransi Matematika (Jika ada nilai tolerance)
            if ($soal->tolerance > 0 && is_numeric($studentAnswer)) {
                $diff = abs((float)$studentAnswer - (float)$soal->correct_answer);
                if ($diff <= (float)$soal->tolerance) {
                    $isCorrect = true;
                    $points = 10;
                }
            }

            // B. Cek Keyword (Jika tidak lolos cek mtk atau soal non-angka)
            if (!$isCorrect && $soal->keywords) {
                $matchedKeywords = 0;
                foreach ($soal->keywords as $kw) {
                    if (stripos($studentAnswer, $kw) !== false) {
                        $matchedKeywords++;
                    }
                }

                // Hitung poin berdasarkan persentase keyword yang ada
                $totalKeywords = count($soal->keywords);
                if ($totalKeywords > 0) {
                    $points = ($matchedKeywords / $totalKeywords) * 10;
                    if ($points > 0) $isCorrect = true;
                }
            }
        }

        // Save di db

        $answer = Answer::updateOrCreate(
            ['session_id' => $request->session_id, 'soal_id' => $soal->id],
            [
                'answer_text' => $studentAnswer,
                'is_correct'  => $isCorrect,
                'points'      => $points
            ]
        );

        // Update total score di ExamSession
        $totalScore = Answer::where('session_id', $request->session_id)->sum('points');
        ExamSession::where('id', $request->session_id)->update(['score' => $totalScore]);

        return response()->json([
            'status' => 'success',
            'is_correct' => $isCorrect,
            'points_earned' => $points,
            'current_total_score' => $totalScore
        ]);
    }

    public function getSoals($ulangan_id)
    {
        $exam = \App\Models\Exam::with('soals')->find($ulangan_id);

        if (!$exam) {
            return response()->json([
                'status' => 'error',
                'message' => 'Jadwal ujian ID ' . $ulangan_id . ' tidak ditemukan'
            ], 404);
        }

        return response()->json([
            'status' => 'success',
            'data' => $exam->soals
        ]);
    }

    public function submitUjian(Request $request, $ulangan_id)
    {
        try {
            $request->validate(['jawaban' => 'required|array']);

            // 1. Cari Sesi
            $session = \App\Models\ExamSession::where('exam_id', $ulangan_id)
                ->where('student_id', \Illuminate\Support\Facades\Auth::id())
                ->where('status', 'progress')
                ->latest()
                ->first();

            if (!$session) {
                return response()->json(['status' => 'error', 'message' => 'Sesi tidak ditemukan!'], 400);
            }

            $totalScore = 0;
            $jawabanSiswa = $request->jawaban;

            foreach ($jawabanSiswa as $soalId => $textJawaban) {
                $soal = \App\Models\BankSoal::find($soalId);
                if (!$soal) continue;

                $isCorrect = false;
                $points = 0;

                if ($soal->type === 'pg') {
                    if (strtolower(trim($textJawaban)) === strtolower(trim($soal->correct_answer))) {
                        $isCorrect = true;
                        $points = 50; 
                    }
                } else {
                    // Gunakan optional chaining atau null coalescing biar gak crash kalau tolerance kosong
                    $tolerance = (float)($soal->tolerance ?? 0);
                    if (is_numeric($textJawaban) && abs((float)$textJawaban - (float)$soal->correct_answer) <= $tolerance) {
                        $isCorrect = true;
                        $points = 50;
                    }
                }

                $totalScore += $points;

                \App\Models\Answer::updateOrCreate(
                    ['session_id' => $session->id, 'soal_id' => $soalId],
                    ['answer_text' => $textJawaban, 'is_correct' => $isCorrect, 'points' => $points]
                );
            }

            $session->update([
                'score' => $totalScore,
                'status' => 'finished',
                'finished_at' => now()
            ]);

            return response()->json(['status' => 'success', 'message' => 'Ujian Berhasil!']);

        } catch (\Exception $e) {
            return response()->json([
                'status' => 'error',
                'message' => 'Aduh Azil, Laravel bilang: ' . $e->getMessage(),
                'file' => $e->getFile(),
                'line' => $e->getLine()
            ], 500);
        }
    }
}
