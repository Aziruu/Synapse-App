@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Kelola Kelas </h3>
    <a href="{{ route('admin.classes.create') }}" class="btn btn-primary">
        <i class="mdi mdi-plus"></i> Tambah Kelas
    </a>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card"> <div class="card">
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
                                    <a href="{{ route('admin.classes.edit', $class->id) }}" class="btn btn-warning btn-sm text-white">Edit</a>
                                    <form action="{{ route('admin.classes.destroy', $class->id) }}" method="POST" class="d-inline delete-form">
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