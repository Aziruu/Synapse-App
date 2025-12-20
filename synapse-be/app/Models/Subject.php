<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Subject extends Model
{
    protected $fillable = ['subject_name'];

    // Relasi ke Bank Soal
    public function bankSoals()
    {
        return $this->hasMany(BankSoal::class, 'subject_id');
    }
}