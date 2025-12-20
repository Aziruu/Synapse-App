<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Exam extends Model {
    protected $fillable = ['guru_id', 'subject_id', 'title', 'start_time', 'end_time', 'duration', 'token'];

    public function classes() {
        return $this->belongsToMany(ClassRoom::class, 'exam_class', 'exam_id', 'class_id');
    }

    public function soals() {
        return $this->belongsToMany(BankSoal::class, 'exam_soal', 'exam_id', 'soal_id')
                    ->withPivot('order');
    }
}