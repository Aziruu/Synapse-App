<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ExamSession extends Model
{
    use HasFactory;

    protected $fillable = [
        'exam_id',
        'student_id',
        'start_at',
        'status',
        'score',
        'finished_at'
    ];
    
    public function answers() {
        return $this->hasMany(Answer::class, 'session_id');
    }
}
