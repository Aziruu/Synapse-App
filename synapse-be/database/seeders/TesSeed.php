<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\BankSoal;
use App\Models\Exam; // Tambahkan ini
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TesSeed extends Seeder
{
    public function run(): void
    {
        // 1-3. Users
        $admin = User::create(['name' => 'Admin', 'email' => 'admin@synapse.id', 'password' => Hash::make('123'), 'role' => 'admin', 'nis_nip' => 'ADMIN-001']);
        $guru = User::create(['name' => 'Guru Mulyadi', 'email' => 'mulyadi@synapse.id', 'password' => Hash::make('123'), 'role' => 'guru', 'nis_nip' => 'GURU-001']);
        $siswa = User::create(['name' => 'Nazzril', 'email' => 'aziruu@synapse.id', 'password' => Hash::make('123'), 'role' => 'siswa', 'nis_nip' => '222310156']);

        // 4. Kelas & Mapel
        $kelas = ClassRoom::create(['class_name' => 'XII RPL 1']);
        $mapel = Subject::create(['subject_name' => 'Matematika']);

        // 5-6. Buat 2 Soal di Bank Soal
        $s1 = BankSoal::create([
            'guru_id' => $guru->id,
            'subject_id' => $mapel->id,
            'question_text' => 'Berapa keliling lingkaran r=7?',
            'type' => 'essay',
            'correct_answer' => '43.96',
            'tolerance' => 0.05
        ]);
        $s2 = BankSoal::create([
            'guru_id' => $guru->id,
            'subject_id' => $mapel->id,
            'question_text' => 'Widget utama Flutter?',
            'type' => 'pg',
            'options' => ['a' => 'MaterialApp', 'b' => 'Scaffold'],
            'correct_answer' => 'a'
        ]);

        $ujian = Exam::create([
            'guru_id' => $guru->id,
            'subject_id' => $mapel->id,
            'title' => 'Ulangan Harian Matematika',
            'start_time' => now(),
            'end_time' => now()->addHours(24),
            'duration' => 120,
            'token' => 'MTK123'
        ]);

        // 1. HUBUNGKAN SOAL KE UJIAN
        $ujian->soals()->attach([$s1->id, $s2->id]);

        // 2. HUBUNGKAN SISWA KE KELAS
        $siswa->classes()->attach($kelas->id);

        // 3. HUBUNGKAN UJIAN KE KELAS
        $ujian->classes()->attach($kelas->id);
    }
}
