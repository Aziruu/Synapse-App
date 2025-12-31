@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Konfigurasi Ujian Baru </h3>
    <a href="{{ route('admin.exams.index') }}" class="btn btn-light">Batal</a>
</div>

<form action="{{ route('admin.exams.store') }}" method="POST" class="forms-sample">
    @csrf
    <div class="row">
        {{-- Info Utama --}}
        <div class="col-md-7 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Informasi Dasar</h4>
                    <div class="form-group">
                        <label>Judul Ujian</label>
                        <input type="text" name="title" class="form-control" placeholder="Contoh: UTS Semester Ganjil" required>
                    </div>
                    <div class="form-group">
                        <label>Mata Pelajaran</label>
                        <select name="subject_id" class="form-control" required>
                            @foreach($subjects as $s)
                                <option value="{{ $s->id }}">{{ $s->subject_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="row">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Mulai</label>
                                <input type="datetime-local" name="start_time" class="form-control" required>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <div class="form-group">
                                <label>Selesai</label>
                                <input type="datetime-local" name="end_time" class="form-control" required>
                            </div>
                        </div>
                    </div>
                    <div class="form-group">
                        <label>Durasi (Menit)</label>
                        <input type="number" name="duration" class="form-control" value="90" required>
                    </div>
                </div>
            </div>
        </div>

        {{-- Pilih Kelas --}}
        <div class="col-md-5 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pilih Kelas</h4>
                    <div class="form-group">
                        @foreach($classes as $c)
                        <div class="form-check">
                            <label class="form-check-label text-muted">
                                <input type="checkbox" name="class_ids[]" value="{{ $c->id }}" class="form-check-input"> 
                                {{ $c->class_name }} 
                            </label>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
        </div>

        {{-- Pilih Soal --}}
        <div class="col-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">
                    <h4 class="card-title">Pilih Soal dari Bank Soal</h4>
                    <div class="table-responsive" style="max-height: 400px; overflow-y: auto;">
                        <table class="table table-bordered">
                            <thead>
                                <tr>
                                    <th width="50px">Pilih</th>
                                    <th>Tipe</th>
                                    <th>Pertanyaan</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach($bankSoals as $soal)
                                <tr>
                                    <td class="text-center">
                                        <input type="checkbox" name="soal_ids[]" value="{{ $soal->id }}">
                                    </td>
                                    <td><span class="badge badge-outline-secondary">{{ strtoupper($soal->type) }}</span></td>
                                    <td>{{ Str::limit($soal->question_text, 100) }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <button type="submit" class="btn btn-gradient-primary btn-block h3">Jadwalkan Ujian Sekarang! 🚀</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</form>
@endsection