@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Data Siswa </h3>
    <div class="btn-group">
        {{-- Link ke halaman tambah manual --}}
        <a href="{{ route('admin.users.create') }}" class="btn btn-primary m-2">
            <i class="mdi mdi-account-plus"></i> Tambah Manual
        </a>
        {{-- Link ke halaman khusus upload CSV --}}
        <a href="{{ route('admin.users.import_view') }}" class="btn btn-success text-white m-2">
            <i class="mdi mdi-file-import"></i> Upload CSV
        </a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <h4 class="card-title">Daftar Siswa Synapse</h4>
        <div class="table-responsive">
            <table class="table table-striped table-hover">
                <thead>
                    <tr>
                        <th>Nama Siswa</th>
                        <th>Email</th>
                        <th>NIP / NIS</th>
                        <th>Kelas</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($users as $u)
                    <tr>
                        <td class="py-1">{{ $u->name }}</td>
                        <td>{{ $u->email }}</td>
                        <td>{{ $u->nis_nip }}</td>
                        <td>
                            @foreach($u->classes as $c)
                                <label class="badge badge-gradient-info">{{ $c->class_name }}</label>
                            @endforeach
                        </td>
                        <td>
                            <div class="d-flex">
                                {{-- TOMBOL EDIT: Link ke halaman edit --}}
                                <a href="{{ route('admin.users.edit', $u->id) }}" class="btn btn-warning btn-sm text-white mr-2">
                                    <i class="mdi mdi-pencil"></i> Edit
                                </a>

                                {{-- TOMBOL HAPUS: Pakai form & konfirmasi --}}
                                <form action="{{ route('admin.users.destroy', $u->id) }}" method="POST" class="delete-form">
                                    @csrf 
                                    @method('DELETE')
                                    <button type="button" class="btn btn-danger btn-sm btn-delete">
                                        <i class="mdi mdi-trash-can"></i> Hapus
                                    </button>
                                </form>
                            </div>
                        </td>
                    </tr>
                    @endforeach
                </tbody>
            </table>
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
                title: 'Hapus Siswa?',
                text: "Siswa ini bakal kehilangan datanya, lho!",
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