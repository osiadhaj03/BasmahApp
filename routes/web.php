<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Teacher\TeacherLessonController;
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
        
        // User Management Routes
        Route::resource('users', UserController::class)->names('admin.users');
        Route::get('teachers', [UserController::class, 'teachers'])->name('admin.users.teachers');
        Route::get('students', [UserController::class, 'students'])->name('admin.users.students');
        
        // Lesson Management Routes
        Route::resource('lessons', LessonController::class)->names('admin.lessons');
        Route::resource('attendances', AttendanceController::class)->names('admin.attendances');
        
        // Attendance Routes
        Route::get('attendances-bulk', [AttendanceController::class, 'bulk'])->name('admin.attendances.bulk');
        Route::post('attendances-bulk', [AttendanceController::class, 'bulkStore'])->name('admin.attendances.bulk-store');
        Route::get('attendances-reports', [AttendanceController::class, 'reports'])->name('admin.attendances.reports');
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

// Teacher Routes
Route::middleware('teacher')->group(function () {
    Route::get('/teacher/dashboard', [TeacherDashboardController::class, 'dashboard'])->name('teacher.dashboard');
    
    // Teacher Lesson Management
    Route::resource('/teacher/lessons', TeacherLessonController::class, [
        'as' => 'teacher'
    ]);
    Route::get('/teacher/lessons/{lesson}/manage-students', [TeacherLessonController::class, 'manageStudents'])
        ->name('teacher.lessons.manage-students');
    Route::post('/teacher/lessons/{lesson}/add-student', [TeacherLessonController::class, 'addStudent'])
        ->name('teacher.lessons.add-student');
    Route::delete('/teacher/lessons/{lesson}/remove-student/{student}', [TeacherLessonController::class, 'removeStudent'])
        ->name('teacher.lessons.remove-student');
    Route::delete('/teacher/lessons/{lesson}/remove-students', [TeacherLessonController::class, 'removeStudents'])
        ->name('teacher.lessons.remove-students');
    Route::delete('/teacher/lessons/{lesson}/remove-all-students', [TeacherLessonController::class, 'removeAllStudents'])
        ->name('teacher.lessons.remove-all-students');
    
    // Teacher Attendance Management (view only for lessons they teach)
    Route::get('/teacher/attendances', [AttendanceController::class, 'index'])->name('teacher.attendances.index');
    Route::get('/teacher/attendances/create', [AttendanceController::class, 'create'])->name('teacher.attendances.create');
    Route::post('/teacher/attendances', [AttendanceController::class, 'store'])->name('teacher.attendances.store');
    Route::get('/teacher/attendances/bulk', [AttendanceController::class, 'bulk'])->name('teacher.attendances.bulk');
    Route::post('/teacher/attendances/bulk', [AttendanceController::class, 'bulkStore'])->name('teacher.attendances.bulk-store');
    Route::get('/teacher/lessons/{lesson}/students', [AttendanceController::class, 'getStudents'])
        ->name('teacher.lessons.students');
});

// Student Routes
Route::middleware('student')->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/check-in', [StudentController::class, 'checkIn'])->name('student.checkin');
    
    // QR Code Scanner for Students
    Route::get('/qr-scanner', [QRCodeController::class, 'scanner'])->name('student.qr.scanner');
    Route::post('/qr-scan', [QRCodeController::class, 'scanQR'])->name('student.qr.scan');
});
