<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\ExamController;

Route::post('/login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {

    // Auth & Profile
    Route::get('/me', [AuthController::class, 'me']);
    Route::post('/logout', [AuthController::class, 'logout']);

    // Exam Features (Ini yang buat Flutter kamu nanti)
    Route::get('/exams', [ExamController::class, 'index']);
    Route::post('/join-exam', [ExamController::class, 'joinExam']);
    Route::get('/exam-report/{exam_id}', [ExamController::class, 'report']);
    Route::get('/ulangan/{ulangan_id}/soal', [ExamController::class, 'getSoals']);
    Route::post('/ulangan/{ulangan_id}/submit', [ExamController::class, 'submitUjian']);
});
