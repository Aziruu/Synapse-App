<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BankSoal;
use App\Models\Subject;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Auth;

class BankSoalController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $soals = BankSoal::with(['subject', 'guru'])->latest()->get();
        return view('admin.bank_soals.index', compact('soals'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $subjects = Subject::all();
        return view('admin.bank_soals.create', compact('subjects'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'subject_id' => 'required',
            'question_text' => 'required',
            'type' => 'required|in:pg,essay',
            'question_image' => 'nullable|image|max:2048',
            'correct_answer' => 'required',
        ]);

        $data = $request->all();
        $data['guru_id'] = Auth::id();

        // Urusan Gambar
        if ($request->hasFile('question_image')) {
            $data['question_image'] = $request->file('question_image')->store('bank_soal', 'public');
        }

        // Simpan Soal (Laravel otomatis handle JSON casting)
        BankSoal::create($data);

        return redirect()->route('admin.bank-soals.index')->with('success', 'Soal berhasil ditambahkan ke bank!');
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
    public function edit( $id)
    {
        $soal = BankSoal::findOrFail($id);
        $subjects = Subject::all();
        return view('admin.bank_soals.edit', compact('soal', 'subjects'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $soal = BankSoal::findOrFail($id);
        $data = $request->all();

        if ($request->hasFile('question_image')) {
            if ($soal->question_image) Storage::disk('public')->delete($soal->question_image);
            $data['question_image'] = $request->file('question_image')->store('bank_soal', 'public');
        }

        $soal->update($data);
        return redirect()->route('admin.bank-soals.index')->with('success', 'Soal berhasil diupdate!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $soal = BankSoal::findOrFail($id);
        if ($soal->question_image) Storage::disk('public')->delete($soal->question_image);
        $soal->delete();

        return back()->with('success', 'Soal dihapus selamanya!');
    }
}
