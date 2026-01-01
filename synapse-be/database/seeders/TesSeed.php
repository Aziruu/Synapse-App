<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\BankSoal;
use App\Models\Exam;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TesSeed extends Seeder
{
    public function run(): void
    {
        //  Akun
        $admin = User::create([
            'name' => 'Administrator Synapse', 
            'email' => 'admin@synapse.id', 
            'password' => Hash::make('123'), 
            'role' => 'admin', 
            'nis_nip' => 'ADMIN-001'
        ]);

        $guru = User::create([
            'name' => 'Drs. Mulyadi', 
            'email' => 'mulyadi@synapse.id', 
            'password' => Hash::make('123'), 
            'role' => 'guru', 
            'nis_nip' => 'GURU-001'
        ]);

        $siswa = User::create([
            'name' => 'Nazzril Ibrahim',
            'email' => 'aziruu@synapse.id', 
            'password' => Hash::make('123'), 
            'role' => 'siswa', 
            'nis_nip' => '222310156'
        ]);

        //  Kelas & Mapel
        $kelas = ClassRoom::create(['class_name' => 'XII RPL 1']);
        $mapel = Subject::create(['subject_name' => 'Matematika & Pemrograman']);

        //  Bank Soal (5 Soal)
        $s1 = BankSoal::create([
            'guru_id' => $guru->id,
            'subject_id' => $mapel->id,
            'question_text' => 'Berapa keliling lingkaran jika jari-jari (r) adalah 7?',
            'type' => 'essay',
            'correct_answer' => '43.96',
            'tolerance' => 0.05
        ]);

        $s2 = BankSoal::create([
            'guru_id' => $guru->id,
            'subject_id' => $mapel->id,
            'question_text' => 'Widget utama yang digunakan untuk membangun struktur dasar halaman di Flutter adalah?',
            'type' => 'pg',
            'options' => ['a' => 'Scaffold', 'b' => 'Center', 'c' => 'SizedBox', 'd' => 'Padding'],
            'correct_answer' => 'a'
        ]);

        $s3 = BankSoal::create([
            'guru_id' => $guru->id,
            'subject_id' => $mapel->id,
            'question_text' => 'Jika 2x + 5 = 15, maka nilai x adalah?',
            'type' => 'essay',
            'correct_answer' => '5',
            'tolerance' => 0
        ]);

        $s4 = BankSoal::create([
            'guru_id' => $guru->id,
            'subject_id' => $mapel->id,
            'question_text' => 'Perintah untuk menambahkan dependensi baru di Flutter melalui terminal adalah?',
            'type' => 'pg',
            'options' => ['a' => 'flutter pub get', 'b' => 'flutter pub add', 'c' => 'flutter upgrade', 'd' => 'flutter clean'],
            'correct_answer' => 'b'
        ]);

        $s5 = BankSoal::create([
            'guru_id' => $guru->id,
            'subject_id' => $mapel->id,
            'question_text' => 'State management yang dikembangkan secara resmi oleh tim Google untuk Flutter adalah?',
            'type' => 'pg',
            'options' => ['a' => 'Provider', 'b' => 'GetX', 'c' => 'Bloc', 'd' => 'Riverpod'],
            'correct_answer' => 'a'
        ]);

        // Buat Ujian
        $ujian = Exam::create([
            'guru_id' => $guru->id,
            'subject_id' => $mapel->id,
            'title' => 'Ulangan Harian: Logika & Flutter',
            'start_time' => now(),
            'end_time' => now()->addHours(24),
            'duration' => 90,
            'token' => 'SYNAPSE'
        ]);

        //  Hubungkan Relasi
        $ujian->soals()->attach([$s1->id, $s2->id, $s3->id, $s4->id, $s5->id]);
        $siswa->classes()->attach($kelas->id);
        $ujian->classes()->attach($kelas->id);
    }
}