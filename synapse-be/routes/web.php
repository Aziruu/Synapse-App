<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\ClassRoomController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\BankSoalController;
use App\Http\Controllers\Admin\ExamController;

Route::get('/', function () {
    return view('welcome');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::resource('classes', ClassRoomController::class);
    // Route::resource('subjects', SubjectController::class);
    // Route::resource('bank-soals', BankSoalController::class);
    // Route::resource('exams', ExamController::class);
});
