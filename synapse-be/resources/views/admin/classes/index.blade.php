@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Kelola Kelas </h3>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
        <i class="mdi mdi-plus"></i> Tambah Kelas
    </button>
</div>

<div class="row">
    <div class="col-lg-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Kelas</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Kelas</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($classes as $class)
                            <tr>
                                <td>{{ $class->class_name }}</td>
                                <td>
                                    <button class="btn btn-warning btn-sm text-white" 
                                            data-toggle="modal" 
                                            data-target="#modalEdit{{ $class->id }}">
                                        Edit
                                    </button>
                                    
                                    <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm delete-btn">Hapus</button>
                                    </form>
                                </td>
                            </tr>

                            <div class="modal fade" id="modalEdit{{ $class->id }}" tabindex="-1">
                                <div class="modal-dialog">
                                    <div class="modal-content">
                                        <form action="{{ route('admin.classes.update', $class->id) }}" method="POST">
                                            @csrf @method('PUT')
                                            <div class="modal-header">
                                                <h5 class="modal-title">Ubah Nama Kelas</h5>
                                            </div>
                                            <div class="modal-body">
                                                <input type="text" name="class_name" class="form-control" value="{{ $class->class_name }}" required>
                                            </div>
                                            <div class="modal-footer">
                                                <button type="submit" class="btn btn-success">Simpan Perubahan</button>
                                            </div>
                                        </form>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.classes.store') }}" method="POST">
                @csrf
                <div class="modal-header">
                    <h5 class="modal-title">Tambah Kelas Baru</h5>
                </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label>Nama Kelas</label>
                        <input type="text" name="class_name" class="form-control" placeholder="Contoh: XII RPL 2" required>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // SweetAlert buat hapus biar makin pro
    $('.delete-btn').on('click', function(e) {
        let form = $(this).closest('form');
        Swal.fire({
            title: 'Hapus Kelas?',
            text: "Data siswa di kelas ini juga mungkin terpengaruh.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#d33',
            confirmButtonText: 'Ya, Hapus!'
        }).then((result) => {
            if (result.isConfirmed) form.submit();
        });
    });
</script>
@endsection