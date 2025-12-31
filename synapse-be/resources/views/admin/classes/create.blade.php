@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Tambah Kelas Baru </h3>
    <a href="{{ route('admin.classes.index') }}" class="btn btn-light">Kembali</a>
</div>
<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{ route('admin.classes.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label>Nama Kelas</label>
                        <input type="text" name="class_name" class="form-control" placeholder="Contoh: XII RPL 1" required>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary mr-2">Simpan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection