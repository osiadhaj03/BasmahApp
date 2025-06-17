<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\QRCodeController;

Route::get('/', function () {
    return view('welcome');
});

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminLoginController::class, 'login']);
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    
    // Protected Admin Routes
    Route::middleware('admin')->group(function () {
        Route::get('dashboard', [AdminController::class, 'dashboard'])->name('admin.dashboard');
        Route::resource('lessons', LessonController::class)->names('admin.lessons');
        Route::resource('attendances', AttendanceController::class)->names('admin.attendances');
        Route::get('lessons/{lesson}/students', [AttendanceController::class, 'getStudents'])
            ->name('admin.lessons.students');
        
        // QR Code Routes for Teachers/Admins
        Route::get('lessons/{lesson}/qr-generate', [QRCodeController::class, 'generateLessonQR'])
            ->name('admin.lessons.qr.generate');
        Route::get('lessons/{lesson}/qr-display', [QRCodeController::class, 'displayQR'])
            ->name('admin.lessons.qr.display');
        Route::get('lessons/{lesson}/qr-info', [QRCodeController::class, 'getLessonQRInfo'])
            ->name('admin.lessons.qr.info');
    });
});

// Student Routes
Route::middleware('student')->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/check-in', [StudentController::class, 'checkIn'])->name('student.checkin');
    
    // QR Code Scanner for Students
    Route::get('/qr-scanner', [QRCodeController::class, 'scanner'])->name('student.qr.scanner');
    Route::post('/qr-scan', [QRCodeController::class, 'scanQR'])->name('student.qr.scan');
});
