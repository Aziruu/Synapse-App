@extends('layouts.app')

@section('content')
<div class="page-header">
    <h3 class="page-title"> Buat Pertanyaan Baru </h3>
    <a href="{{ route('admin.bank-soals.index') }}" class="btn btn-light">Kembali</a>
</div>

<div class="row">
    <div class="col-12 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <form action="{{ route('admin.bank-soals.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    <div class="form-group">
                        <label>Mata Pelajaran</label>
                        <select name="subject_id" class="form-control" required>
                            @foreach($subjects as $sbj)
                                <option value="{{ $sbj->id }}">{{ $sbj->subject_name }}</option>
                            @endforeach
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Tipe Soal</label>
                        <select name="type" id="type_soal" class="form-control" required>
                            <option value="pg">Pilihan Ganda (PG)</option>
                            <option value="essay">Essay</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label>Pertanyaan</label>
                        <textarea name="question_text" class="form-control" rows="4" required></textarea>
                    </div>

                    <div class="form-group">
                        <label>Gambar Pendukung (Opsional)</label>
                        <input type="file" name="question_image" class="form-control">
                    </div>

                    <div id="section_pg">
                        <hr>
                        <label class="text-info font-weight-bold">Opsi Jawaban (JSON Format)</label>
                        <div class="row">
                            @foreach(['a','b','c','d','e'] as $opt)
                            <div class="col-md-6">
                                <div class="form-group">
                                    <label>Opsi {{ strtoupper($opt) }}</label>
                                    <input type="text" name="options[{{ $opt }}]" class="form-control pg-input">
                                </div>
                            </div>
                            @endforeach
                        </div>
                    </div>

                    <div id="section_essay" style="display: none;">
                        <hr>
                        <div class="form-group">
                            <label>Keywords (Pisahkan dengan koma)</label>
                            <input type="text" name="keywords" class="form-control" placeholder="daun, fotosintesis, hijau">
                        </div>
                    </div>

                    <div class="form-group">
                        <label id="label_kunci">Kunci Jawaban</label>
                        <textarea name="correct_answer" class="form-control" rows="2" required></textarea>
                    </div>

                    <button type="submit" class="btn btn-gradient-primary mr-2">Simpan ke Bank Soal</button>
                </form>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Logic Ganti UI PG/Essay
    $('#type_soal').on('change', function() {
        if ($(this).val() == 'pg') {
            $('#section_pg').show();
            $('#section_essay').hide();
            $('#label_kunci').text('Kunci Jawaban (Masukkan Huruf a/b/c/d/e)');
            $('.pg-input').attr('required', true);
        } else {
            $('#section_pg').hide();
            $('#section_essay').show();
            $('#label_kunci').text('Jawaban Benar (Untuk Referensi Koreksi)');
            $('.pg-input').attr('required', false);
        }
    });
</script>
@endsection