@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Tambah Siswa Baru </h3>
    <a href="{{ route('admin.users.index') }}" class="btn btn-light">Kembali</a>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{ route('admin.users.store') }}" method="POST">
                    @csrf
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" id="name" placeholder="Nama Siswa" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" placeholder="email@synapse.id" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password (Default: 123)</label>
                        <input type="password" name="password" class="form-control" id="password" value="123" required>
                    </div>
                    <div class="form-group">
                        <label for="class_id">Pilih Kelas</label>
                        <select name="class_id" class="form-control" id="class_id" required>
                            <option value="">-- Pilih Kelas --</option>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}">{{ $c->class_name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-gradient-primary mr-2">Simpan Data</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection