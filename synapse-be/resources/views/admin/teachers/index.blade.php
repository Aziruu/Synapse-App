@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Manajemen Data Guru </h3>
    <a href="{{ route('admin.teachers.create') }}" class="btn btn-primary">
        <i class="mdi mdi-account-plus"></i> Tambah Guru Baru
    </a>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Guru Synapse</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Lengkap</th>
                                <th>Email</th>
                                <th>NIP</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($teachers as $t)
                            <tr>
                                <td>{{ $t->name }}</td>
                                <td>{{ $t->email }}</td>
                                <td><span class="badge badge-gradient-success">{{ $t->nis_nip }}</span></td>
                                <td>
                                    <a href="{{ route('admin.teachers.edit', $t->id) }}" class="btn btn-warning btn-sm text-white">Edit</a>
                                    
                                    <form action="{{ route('admin.teachers.destroy', $t->id) }}" method="POST" class="d-inline">
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
            const form = e.target.closest('form');
            Swal.fire({
                title: 'Hapus Data Guru?',
                text: "Semua ujian yang dibuat guru ini mungkin akan ikut terhapus!",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                confirmButtonText: 'Ya, Hapus!',
                cancelButtonText: 'Batal'
            }).then((result) => {
                if (result.isConfirmed) { form.submit(); }
            });
        }
    });
</script>
@endsection