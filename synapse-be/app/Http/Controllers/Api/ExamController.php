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

    // Masuk Ujian Pakai Token
    public function joinExam(Request $request)
    {
        $request->validate(['token' => 'required']);

        // Cari ujian berdasarkan token
        $exam = Exam::where('token', $request->token)->first();

        if (!$exam) {
            return response()->json(['message' => 'Token ujian tidak valid.'], 404);
        }

        // Cek apakah waktu ujian sudah mulai atau sudah lewat
        $now = Carbon::now();
        if ($now->lt($exam->start_time) || $now->gt($exam->end_time)) {
            return response()->json(['message' => 'Ujian belum dimulai atau sudah berakhir.'], 403);
        }

        // Buat Sesi Ujian baru buat siswa ini
        $session = ExamSession::firstOrCreate([
            'exam_id' => $exam->id,
            'student_id' => $request->user()->id,
        ], [
            'start_at' => $now,
            'status' => 'progress'
        ]);

        // Kirim data ujian beserta soal-soalnya ke Flutter
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
            'answer_text'=> 'required',
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
}
