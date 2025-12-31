@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Edit Mata Pelajaran </h3>
    <a href="{{ route('admin.subjects.index') }}" class="btn btn-light">Batal</a>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form class="forms-sample" action="{{ route('admin.subjects.update', $subject->id) }}" method="POST">
                    @csrf
                    @method('PUT')
                    
                    <div class="form-group">
                        <label for="subject_name">Nama Mata Pelajaran</label>
                        <input type="text" name="subject_name" class="form-control" id="subject_name" value="{{ $subject->subject_name }}" required>
                    </div>
                    
                    <button type="submit" class="btn btn-gradient-info mr-2">Update Mapel</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection