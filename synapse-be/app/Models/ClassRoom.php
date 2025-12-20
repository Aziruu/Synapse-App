<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRoom extends Model {
    protected $table = 'classes';
    protected $fillable = ['class_name'];

    public function users() {
        return $this->belongsToMany(User::class, 'class_user', 'class_id', 'user_id');
    }

    public function exams() {
        return $this->belongsToMany(Exam::class, 'exam_class', 'class_id', 'exam_id');
    }
}