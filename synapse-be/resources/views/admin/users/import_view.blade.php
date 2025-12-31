@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Import Siswa via CSV </h3>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Upload File</h4>
                <p class="card-description"> Pastikan urutan kolom: <span class="text-danger">Nama, Email, NIS, Nama Kelas</span> </p>
                
                <form class="forms-sample" action="{{ route('admin.users.import') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Pilih File .csv</label>
                        <input type="file" name="file_csv" class="form-control" required>
                    </div>
                    <button type="submit" class="btn btn-gradient-success text-white mr-2">Mulai Import 🚀</button>
                    <a href="{{ route('admin.users.index') }}" class="btn btn-light">Kembali</a>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection