@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Update Konfigurasi Ujian </h3>
    <a href="{{ route('admin.exams.index') }}" class="btn btn-light">Batal</a>
</div>

<form action="{{ route('admin.exams.update', $exam->id) }}" method="POST" class="forms-sample">
    @csrf @method('PUT')
    <div class="row">
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <div class="form-group">
                        <label>Judul Ujian</label>
                        <input type="text" name="title" class="form-control" value="{{ $exam->title }}" required>
                    </div>
                    {{-- Input lainnya sesuaikan dengan create.blade.php --}}
                </div>
            </div>
        </div>

        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pilih Kelas</h4>
                    @foreach($classes as $c)
                    <div class="form-check">
                        <label class="form-check-label text-muted">
                            <input type="checkbox" name="class_ids[]" value="{{ $c->id }}" 
                            {{ $exam->classes->contains($c->id) ? 'checked' : '' }} class="form-check-input"> 
                            {{ $c->class_name }}
                        </label>
                    </div>
                    @endforeach
                </div>
            </div>
        </div>
        {{-- Jangan lupa tambahkan loop soal_ids[] juga di bawah sini dengan logika contains() --}}
    </div>
</form>
@endsection