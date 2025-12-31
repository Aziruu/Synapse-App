<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class SubjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $subjects = \App\Models\Subject::all();
        return view('admin.subjects.index', compact('subjects'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.subjects.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['subject_name' => 'required|unique:subjects']);
        \App\Models\Subject::create($request->all());
        return back()->with('success', 'Mata Pelajaran berhasil ditambah!');
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
        $subject = \App\Models\Subject::findOrFail($id);
        return view('admin.subjects.edit', compact('subject'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate(['subject_name' => 'required|unique:subjects,subject_name,' . $id]);
        $subject = \App\Models\Subject::findOrFail($id);
        $subject->update($request->all());
        return back()->with('success', 'Mata Pelajaran berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        \App\Models\Subject::destroy($id);
        return back()->with('success', 'Mata Pelajaran berhasil dihapus!');
    }
}
