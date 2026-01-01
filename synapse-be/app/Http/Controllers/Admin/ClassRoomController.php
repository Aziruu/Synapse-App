<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class ClassRoomController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $classes = \App\Models\ClassRoom::all();
        return view('admin.classes.index', compact('classes'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return view('admin.classes.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate(['class_name' => 'required|unique:classes']);
        \App\Models\ClassRoom::create($request->all());
        return redirect()->route('admin.classes.index')->with('success', 'Data masuk! 🚀');
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
    public function edit($id)
    {
        $class = \App\Models\ClassRoom::findOrFail($id);
        return view('admin.classes.edit', compact('class'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, $id)
    {
        $request->validate(['class_name' => 'required|unique:classes,class_name,' . $id]);
        $class = \App\Models\ClassRoom::findOrFail($id);
        $class->update($request->all());
        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil diubah!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy($id)
    {
        \App\Models\ClassRoom::destroy($id);
        return redirect()->route('admin.classes.index')->with('success', 'Kelas berhasil dihapus!');
    }
}
