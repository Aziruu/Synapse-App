@extends('layouts.app')

@section('content')

{{-- Menampilkan error validasi --}}
@if ($errors->any())
    <div class="alert alert-danger alert-dismissible fade show" role="alert">
        <strong>Aduh, cek lagi:</strong>
        <ul>
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

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
                        {{-- FIX: Tambah ID agar sinkron dengan JS --}}
                        <select name="subject_id" id="subject_select" class="form-control" required>
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
                    <p class="text-muted small">Centang kelas yang akan mengikuti ujian ini.</p>
                    <div class="form-group">
                        @foreach($classes as $c)
                        <div class="form-check form-check-flat form-check-primary">
                            <label class="form-check-label">
                                <input type="checkbox" name="class_ids[]" value="{{ $c->id }}" class="form-check-input"> 
                                {{ $c->class_name }} 
                            <i class="input-helper"></i></label>
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
                    <p class="text-muted small">Soal otomatis difilter berdasarkan Mapel yang kamu pilih.</p>
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
                                {{-- FIX: Tambah class dan data-subject untuk filter JS --}}
                                <tr class="soal-row" data-subject="{{ $soal->subject_id }}">
                                    <td class="text-center">
                                        <input type="checkbox" name="soal_ids[]" value="{{ $soal->id }}" class="soal-checkbox">
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

@section('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {
    const subjectSelect = document.getElementById('subject_select');
    const soalRows = document.querySelectorAll('.soal-row');

    function filterSoal() {
        const selectedSubject = subjectSelect.value;
        soalRows.forEach(row => {
            // Tampilkan hanya soal yang ID Mapelnya sama dengan pilihan
            if (row.getAttribute('data-subject') === selectedSubject) {
                row.style.display = '';
            } else {
                row.style.display = 'none';
                // Uncheck soal yang disembunyikan agar tidak terkirim secara tidak sengaja
                const checkbox = row.querySelector('.soal-checkbox');
                if(checkbox) checkbox.checked = false;
            }
        });
    }

    // Jalankan saat halaman load & saat Mapel diganti
    subjectSelect.addEventListener('change', filterSoal);
    filterSoal(); 
});
</script>
@endsection