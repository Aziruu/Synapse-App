@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Jadwal Ujian </h3>
    <a href="{{ route('admin.exams.create') }}" class="btn btn-primary">
        <i class="mdi mdi-calendar-plus"></i> Buat Ujian Baru
    </a>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Ujian Aktif</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Judul & Mapel</th>
                                <th>Kelas</th>
                                <th>Token</th>
                                <th>Waktu & Durasi</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($exams as $e)
                            <tr>
                                <td>
                                    <strong>{{ $e->title }}</strong><br>
                                    <small class="text-muted">{{ $e->subject->subject_name }}</small>
                                </td>
                                <td>
                                    @foreach($e->classes as $c)
                                        <label class="badge badge-gradient-info">{{ $c->class_name }}</label>
                                    @endforeach
                                </td>
                                <td><code class="h5 text-danger">{{ $e->token }}</code></td>
                                <td>
                                    {{ date('d M, H:i', strtotime($e->start_time)) }}<br>
                                    <small>{{ $e->duration }} Menit</small>
                                </td>
                                <td>
                                    <a href="{{ route('admin.exams.edit', $e->id) }}" class="btn btn-warning btn-sm text-white">Edit</a>
                                    <form action="{{ route('admin.exams.destroy', $e->id) }}" method="POST" class="d-inline delete-form">
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
                title: 'Hapus Ulangan?',
                text: "Ulangan di kelas ini bakal kehilangan datanya, lho!",
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