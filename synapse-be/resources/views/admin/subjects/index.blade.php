@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Kelola Mata Pelajaran </h3>
    {{-- FIX: Ganti tombol modal jadi link ke halaman create --}}
    <a href="{{ route('admin.subjects.create') }}" class="btn btn-primary">
        <i class="mdi mdi-plus"></i> Tambah Mapel
    </a>
</div>

<div class="row">
    {{-- FIX: Gunakan col-12 biar gak kepotong di pojok --}}
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Daftar Mapel</h4>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Nama Mata Pelajaran</th>
                                <th width="200px">Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach($subjects as $s)
                            <tr>
                                <td>{{ $s->subject_name }}</td>
                                <td>
                                    {{-- FIX: Link ke halaman edit --}}
                                    <a href="{{ route('admin.subjects.edit', $s->id) }}" class="btn btn-warning btn-sm text-white mr-2">
                                        <i class="mdi mdi-pencil"></i> Edit
                                    </a>
                                    
                                    {{-- Form Hapus dengan SweetAlert --}}
                                    <form action="{{ route('admin.subjects.destroy', $s->id) }}" method="POST" class="d-inline delete-form">
                                        @csrf @method('DELETE')
                                        <button type="button" class="btn btn-danger btn-sm btn-delete">
                                            <i class="mdi mdi-trash-can"></i> Hapus
                                        </button>
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
                title: 'Hapus Mapel?',
                text: "Mapel ini bakal kehilangan datanya, lho!",
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