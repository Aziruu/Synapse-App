@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Pendaftaran Guru Baru </h3>
    <a href="{{ route('admin.teachers.index') }}" class="btn btn-light">Batal</a>
</div>

@if ($errors->any())
    <div class="alert alert-danger">
        <ul>@foreach ($errors->all() as $error) <li>{{ $error }}</li> @endforeach</ul>
    </div>
@endif

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.teachers.store') }}" method="POST" class="forms-sample">
                    @csrf
                    <div class="form-group">
                        <label>Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" placeholder="Nama Guru" required>
                    </div>
                    <div class="form-group">
                        <label>Email Address</label>
                        <input type="email" name="email" class="form-control" placeholder="email@synapse.com" required>
                    </div>
                    <div class="form-group">
                        <label>NIP (Nomor Induk Pegawai)</label>
                        <input type="text" name="nis_nip" class="form-control" placeholder="Masukkan NIP" required>
                    </div>
                    <div class="form-group">
                        <label>Password</label>
                        <input type="password" name="password" class="form-control" placeholder="Minimal 3 Karakter" required>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary mr-2">Daftarkan Guru 🚀</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection