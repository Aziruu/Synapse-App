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
    Route::post('/join-exam', [ExamController::class, 'joinExam']);
    Route::post('/submit-answer', [ExamController::class, 'submitAnswer']);
    Route::get('/exam-report/{exam_id}', [ExamController::class, 'report']);
});