@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Edit Soal </h3>
    <a href="{{ route('admin.bank-soals.index') }}" class="btn btn-light">Batal</a>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.bank-soals.update', $soal->id) }}" method="POST" enctype="multipart/form-data">
                    @csrf @method('PUT')
                    
                    <div class="form-group">
                        <label>Mata Pelajaran</label>
                        <select name="subject_id" class="form-control">
                            @foreach($subjects as $sbj)
                                <option value="{{ $sbj->id }}" {{ $soal->subject_id == $sbj->id ? 'selected' : '' }}>
                                    {{ $sbj->subject_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tipe Soal</label>
                        <select name="type" class="form-control" disabled>
                            <option value="pg" {{ $soal->type == 'pg' ? 'selected' : '' }}>PG</option>
                            <option value="essay" {{ $soal->type == 'essay' ? 'selected' : '' }}>Essay</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Pertanyaan</label>
                        <textarea name="question_text" class="form-control" rows="4">{{ $soal->question_text }}</textarea>
                    </div>

                    @if($soal->type == 'pg')
                    <div class="row">
                        @foreach($soal->options as $key => $val)
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Opsi {{ strtoupper($key) }}</label>
                                <input type="text" name="options[{{ $key }}]" class="form-control" value="{{ $val }}">
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @endif

                    <div class="form-group">
                        <label>Kunci Jawaban</label>
                        <textarea name="correct_answer" class="form-control" rows="2">{{ $soal->correct_answer }}</textarea>
                    </div>

                    <button type="submit" class="btn btn-gradient-info mr-2">Update Soal</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection