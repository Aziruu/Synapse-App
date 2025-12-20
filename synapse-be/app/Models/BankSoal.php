<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class BankSoal extends Model {
    protected $table = 'bank_soals';
    protected $fillable = ['guru_id', 'subject_id', 'question_text', 'type', 'options', 'correct_answer', 'keywords', 'tolerance'];

    protected $casts = [
        'options' => 'array',
        'keywords' => 'array',
    ];

    public function guru() { return $this->belongsTo(User::class, 'guru_id'); }
    public function subject() { return $this->belongsTo(Subject::class); }
}