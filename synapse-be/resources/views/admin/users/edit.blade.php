@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Ubah Data Siswa </h3>
    <a href="{{ route('admin.users.index') }}" class="btn btn-light">Batal</a>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{ route('admin.users.update', $user->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="name">Nama Lengkap</label>
                        <input type="text" name="name" class="form-control" id="name" value="{{ $user->name }}" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" class="form-control" id="email" value="{{ $user->email }}" required>
                    </div>
                    <div class="form-group">
                        <label for="nis_nip">NIS / NIP</label>
                        <input type="text" name="nis_nip" class="form-control" id="nis_nip" value="{{ $user->nis_nip }}">
                    </div>
                    <div class="form-group">
                        <label for="class_id">Pilih Kelas</label>
                        <select name="class_id" class="form-control" id="class_id" required>
                            @foreach($classes as $c)
                                <option value="{{ $c->id }}" {{ $user->classes->contains($c->id) ? 'selected' : '' }}>
                                    {{ $c->class_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <button type="submit" class="btn btn-gradient-info mr-2">Update Data</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection