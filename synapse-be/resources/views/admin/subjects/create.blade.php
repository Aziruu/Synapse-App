@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Tambah Mata Pelajaran </h3>
    <a href="{{ route('admin.subjects.index') }}" class="btn btn-light">Kembali</a>
</div>
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{ route('admin.subjects.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nama Mata Pelajaran</label>
                        <input type="text" name="subject_name" class="form-control" placeholder="Misal: Bahasa Inggris" required>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary mr-2">Simpan Mapel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection