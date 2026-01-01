<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Exam;
use App\Models\ClassRoom;
use App\Models\BankSoal;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class ExamController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil ujian beserta kelas dan mata pelajarannya
        $exams = Exam::with(['subject', 'classes'])->latest()->get();
        return view('admin.exams.index', compact('exams'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::all();
        $classes = ClassRoom::all();
        $bankSoals = BankSoal::all();
        return view('admin.exams.create', compact('subjects', 'classes', 'bankSoals'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
            'title' => 'required',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
            'duration' => 'required|integer',
            'class_ids' => 'required|array', // Array ID Kelas
            'soal_ids' => 'required|array',  // Array ID Soal
        ]);

        // 1. Simpan Data Utama Ujian
        $exam = Exam::create([
            'guru_id' => Auth::id() ?? 1,
            'subject_id' => $request->subject_id,
            'title' => $request->title,
            'start_time' => $request->start_time,
            'end_time' => $request->end_time,
            'duration' => $request->duration,
            'token' => strtoupper(Str::random(6)),
        ]);

        //  Hubungkan ke Kelas (Tabel exam_class)
        $exam->classes()->attach($request->class_ids);

        // Kita loop biar bisa kasih 'order' (urutan soal)
        foreach ($request->soal_ids as $index => $soalId) {
            $exam->soals()->attach($soalId, ['order' => $index + 1]);
        }

        return redirect()->route('admin.exams.index')->with('success', 'Ujian Berhasil Dijadwalkan! 🚀');
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        $exam = Exam::with(['classes', 'soals'])->findOrFail($id);
        $subjects = Subject::all();
        $classes = ClassRoom::all();
        $bankSoals = BankSoal::all();

        return view('admin.exams.edit', compact('exam', 'subjects', 'classes', 'bankSoals'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'subject_id' => 'required',
            'title' => 'required',
            'start_time' => 'required',
            'end_time' => 'required|after:start_time',
            'duration' => 'required|integer',
            'class_ids' => 'required|array',
            'soal_ids' => 'required|array',
        ]);

        $exam = Exam::findOrFail($id);

        //  Update data utama
        $exam->update($request->except(['class_ids', 'soal_ids']));

        // Sync Kelas (otomatis hapus yang lama, pasang yang baru)
        $exam->classes()->sync($request->class_ids);

        //  Sync Soal dengan Pivot Order
        $soalData = [];
        foreach ($request->soal_ids as $index => $soalId) {
            $soalData[$soalId] = ['order' => $index + 1];
        }
        $exam->soals()->sync($soalData);

        return redirect()->route('admin.exams.index')->with('success', 'Konfigurasi ujian berhasil diperbarui! ✨');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $exam = Exam::findOrFail($id);
        $exam->delete();
        return redirect()->route('admin.exams.index')->with('success', 'Jadwal ujian berhasil dihapus.');
    }
}
