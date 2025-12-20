<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Answer extends Model 
{
    protected $fillable = ['session_id', 'soal_id', 'answer_text', 'is_correct', 'points'];

    public function soal() {
        return $this->belongsTo(BankSoal::class, 'soal_id');
    }
}
