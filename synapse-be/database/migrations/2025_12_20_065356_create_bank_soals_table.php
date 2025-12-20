<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('bank_soals', function (Blueprint $table) {
            $table->id();
            $table->foreignId('guru_id')->constrained('users')->onDelete('cascade');
            $table->foreignId('subject_id')->constrained('subjects')->onDelete('cascade');
            $table->text('question_text');
            $table->enum('type', ['pg', 'essay']);
            
            // Simpan opsi PG dalam JSON: {"a": "Isi", "b": "Isi", ...}
            $table->json('options')->nullable(); 
            
            // Jawaban utama (Kunci Jawaban)
            $table->text('correct_answer'); 

            // Simpan array kata kunci: ["fotosintesis", "daun"]
            $table->json('keywords')->nullable(); 
            // Untuk toleransi angka mtk (misal: 0.01)
            $table->float('tolerance')->default(0); 
            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bank_soals');
    }
};
