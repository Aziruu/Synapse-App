@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Update Profil Guru </h3>
    <a href="{{ route('admin.teachers.index') }}" class="btn btn-light">Batal</a>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.teachers.update', $teacher->id) }}" method="POST" class="forms-sample">
                    @csrf @method('PUT')
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" value="{{ $teacher->name }}" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" value="{{ $teacher->email }}" required>
                    </div>
                    <div class="form-group">
                        <label>NIP (Nomor Induk Pegawai)</label>
                        <input type="text" name="nis_nip" class="form-control" value="{{ $teacher->nis_nip }}" required>
                    </div>
                    <p class="text-muted small">*Password tidak dapat diubah di halaman ini demi keamanan.</p>
                    <button type="submit" class="btn btn-gradient-info mr-2">Simpan Perubahan ✨</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection