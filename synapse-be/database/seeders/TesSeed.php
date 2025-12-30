<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ClassRoom;
use App\Models\Subject;
use App\Models\BankSoal;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TesSeed extends Seeder
{
    public function run(): void
    {
        // 1. Administrator Utama
        User::create([
            'name' => 'Administrator Sistem',
            'email' => 'admin@synapse.id',
            'password' => Hash::make('SynapseAdmin2025'),
            'role' => 'admin',
            'nis_nip' => 'ADMIN-001',
        ]);

        // 2. Tenaga Pendidik (Guru)
        $guru = User::create([
            'name' => 'Drs. H. Mulyadi, M.Pd.',
            'email' => 'mulyadi@synapse.id',
            'password' => Hash::make('GuruSynapse2025'),
            'role' => 'guru',
            'nis_nip' => '198501012010011002',
        ]);

        // 3. Siswa Contoh (Aziruu)
        User::create([
            'name' => 'Nazzril Ibrahim',
            'email' => 'aziruu@synapse.id',
            'password' => Hash::make('SiswaSynapse2025'),
            'role' => 'siswa',
            'nis_nip' => '222310156',
        ]);

        // 4. Data Master Kelas & Mata Pelajaran
        $kelas = ClassRoom::create(['class_name' => 'XII RPL 1']);
        $mapel = Subject::create(['subject_name' => 'Pemrograman Perangkat Bergerak']);

        // 5. Contoh Soal Essay dengan Inovasi Toleransi Matematika
        BankSoal::create([
            'guru_id' => $guru->id,
            'subject_id' => $mapel->id,
            'question_text' => 'Sebuah lingkaran memiliki jari-jari $r = 7 \text{ cm}$. Berapakah keliling lingkaran tersebut? (Gunakan $\pi \approx 3.14$, tuliskan dalam 2 desimal)',
            'type' => 'essay',
            'correct_answer' => '43.96',
            'keywords' => ['empat puluh tiga', 'koma', 'sembilan enam'],
            'tolerance' => 0.05, 
        ]);
        
        // 6. Contoh Soal Pilihan Ganda (PG)
        BankSoal::create([
            'guru_id' => $guru->id,
            'subject_id' => $mapel->id,
            'question_text' => 'Apa nama widget utama dalam Flutter yang digunakan sebagai titik awal aplikasi?',
            'type' => 'pg',
            'options' => [
                'a' => 'MaterialApp',
                'b' => 'Scaffold',
                'c' => 'Container',
                'd' => 'AppBar'
            ],
            'correct_answer' => 'a',
        ]);
    }
}