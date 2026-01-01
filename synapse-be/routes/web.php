<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\ClassRoomController;
use App\Http\Controllers\Admin\SubjectController;
use App\Http\Controllers\Admin\BankSoalController;
use App\Http\Controllers\Admin\ExamController;
use App\Http\Controllers\Admin\TeacherController;

Route::get('/', function () {
    return redirect()->route('admin.classes.index');
});

Route::prefix('admin')->name('admin.')->group(function () {
    Route::get('users/import-page', [UserController::class, 'import_view'])->name('users.import_view');
    Route::post('users/import-proses', [UserController::class, 'import'])->name('users.import');

    Route::resource('users', UserController::class);
    Route::resource('teachers', TeacherController::class);
    Route::resource('classes', ClassRoomController::class);
    Route::resource('subjects', SubjectController::class);
    Route::resource('bank-soals', BankSoalController::class);
    Route::resource('exams', ExamController::class);
});
