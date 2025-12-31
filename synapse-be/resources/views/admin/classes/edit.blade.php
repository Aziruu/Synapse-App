@extends('layouts.app') {{-- Gunakan layout utama --}}

@section('content')
<div class="page-header">
    <h3 class="page-title"> Edit Nama Kelas </h3>
    <a href="{{ route('admin.classes.index') }}" class="btn btn-light">Batal</a>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{ route('admin.classes.update', $class->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="class_name">Nama Kelas</label>
                        <input type="text" name="class_name" class="form-control" id="class_name" value="{{ $class->class_name }}" required>
                    </div>
                    
                    <button type="submit" class="btn btn-gradient-info mr-2">Simpan Perubahan</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection