<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExamSession extends Model
{
    public function answers() {
        return $this->hasMany(Answer::class, 'session_id');
    }
}
