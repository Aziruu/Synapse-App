<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Ambil user dengan role siswa saja
        $users = \App\Models\User::where('role', 'siswa')->with('classes')->get();
        return view('admin.users.index', compact('users'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $classes = \App\Models\ClassRoom::all();
        return view('admin.users.create', compact('classes'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users',
            'password' => 'required|min:3',
            'class_id' => 'required'
        ]);

        // Buat User baru
        $user = \App\Models\User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => bcrypt($request->password),
            'role' => 'siswa',
            'nis_nip' => $request->nis_nip,
        ]);

        // Hubungkan ke kelas lewat tabel pivot class_user
        $user->classes()->attach($request->class_id);

        return back()->with('success', 'Siswa berhasil ditambahkan!');
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
        $user = \App\Models\User::with('classes')->findOrFail($id);
        $classes = \App\Models\ClassRoom::all();
        return view('admin.users.edit', compact('user', 'classes'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        $request->validate([
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'class_id' => 'required'
        ]);

        $user = \App\Models\User::findOrFail($id);

        // Update data user
        $user->update([
            'name' => $request->name,
            'email' => $request->email,
            'nis_nip' => $request->nis_nip,
        ]);

        // Pakai sync() biar hubungan kelas yang lama dihapus & diganti yang baru
        $user->classes()->sync([$request->class_id]);

        return redirect()->route('admin.users.index')->with('success', 'Data siswa berhasil diperbarui! ✨');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        $user = \App\Models\User::findOrFail($id);

        // Putus hubungan kelas dulu baru hapus user-nya
        $user->classes()->detach();
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Siswa berhasil dihapus dari sistem!');
    }

    public function import_view()
    {
        return view('admin.users.import_view');
    }

    // Fungsi buat ngolah CSV 
    public function import(Request $request)
    {
        $request->validate([
            'file_csv' => 'required|mimes:csv,txt'
        ]);

        $file = $request->file('file_csv');
        $handle = fopen($file->getRealPath(), "r");
        fgetcsv($handle, 1000, ",");

        while (($row = fgetcsv($handle, 1000, ",")) !== FALSE) {
            $user = \App\Models\User::create([
                'name'      => $row[0],
                'email'     => $row[1],
                'nis_nip'   => $row[2],
                'password'  => bcrypt('123'),
                'role'      => 'siswa',
            ]);

            $class = \App\Models\ClassRoom::where('class_name', $row[3])->first();
            if ($class) {
                $user->classes()->attach($class->id);
            }
        }

        fclose($handle);
        return redirect()->route('admin.users.index')->with('success', 'Data siswa massal berhasil masuk!');
    }
}
