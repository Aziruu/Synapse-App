@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Kelola Mata Pelajaran </h3>
    <button type="button" class="btn btn-primary" data-toggle="modal" data-target="#modalTambah">
        <i class="mdi mdi-plus"></i> Tambah Mapel
    </button>
</div>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Daftar Mapel</h4>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>Nama Mata Pelajaran</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($subjects as $s)
                    <tr>
                        <td>{{ $s->subject_name }}</td>
                        <td>
                            <button class="btn btn-warning btn-sm text-white" data-toggle="modal" data-target="#modalEdit{{ $s->id }}">Edit</button>
                            <form action="{{ route('admin.subjects.destroy', $s->id) }}" method="POST" class="d-inline">
                                @csrf @method('DELETE')
                                <button type="submit" class="btn btn-danger btn-sm">Hapus</button>
                            </form>
                        </td>
                    </tr>

                    <div class="modal fade" id="modalEdit{{ $s->id }}" tabindex="-1">
                        <div class="modal-dialog">
                            <div class="modal-content">
                                <form action="{{ route('admin.subjects.update', $s->id) }}" method="POST">
                                    @csrf @method('PUT')
                                    <div class="modal-header"><h5 class="modal-title">Edit Mapel</h5></div>
                                    <div class="modal-body">
                                        <input type="text" name="subject_name" class="form-control" value="{{ $s->subject_name }}" required>
                                    </div>
                                    <div class="modal-footer"><button type="submit" class="btn btn-success">Update</button></div>
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

<div class="modal fade" id="modalTambah" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <form action="{{ route('admin.subjects.store') }}" method="POST">
                @csrf
                <div class="modal-header"><h5 class="modal-title">Tambah Mapel Baru</h5></div>
                <div class="modal-body">
                    <input type="text" name="subject_name" class="form-control" placeholder="Misal: Matematika" required>
                </div>
                <div class="modal-footer"><button type="submit" class="btn btn-primary">Simpan</button></div>
            </form>
        </div>
    </div>
</div>
@endsection