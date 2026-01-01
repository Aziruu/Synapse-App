@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Bank Soal Synapse </h3>
    <a href="{{ route('admin.bank-soals.create') }}" class="btn btn-primary">
        <i class="mdi mdi-plus"></i> Tambah Soal Baru
    </a>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Koleksi Pertanyaan Ujian</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Mapel</th>
                                <th>Tipe</th>
                                <th>Pertanyaan</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($soals as $s)
                            <tr>
                                <td>{{ $s->subject->subject_name }}</td>
                                <td>
                                    <label class="badge {{ $s->type == 'pg' ? 'badge-info' : 'badge-warning' }}">
                                        {{ strtoupper($s->type) }}
                                    </label>
                                </td>
                                <td style="max-width: 300px; white-space: nowrap; overflow: hidden; text-overflow: ellipsis;">
                                    {{ $s->question_text }}
                                </td>
                                <td>
                                    <a href="{{ route('admin.bank-soals.edit', $s->id) }}" class="btn btn-warning btn-sm text-white">Edit</a>
                                    <form action="{{ route('admin.bank-soals.destroy', $s->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    document.addEventListener('click', function (e) {
        if (e.target && e.target.classList.contains('btn-delete')) {
            e.preventDefault();
            const form = e.target.closest('form');
            
            Swal.fire({
                title: 'Hapus Soal?',
                text: "Soal ini bakal kehilangan datanya, lho!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) {
                    // Pakai native submit biar langsung tembus ke controller
                    form.submit(); 
                }
            });
        }
    });
</script>
@endsection