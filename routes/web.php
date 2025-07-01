<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Auth\AdminLoginController;
use App\Http\Controllers\Auth\StudentRegisterController;
use App\Http\Controllers\Admin\AdminController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\LessonController;
use App\Http\Controllers\Admin\AttendanceController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\BookController;
use App\Http\Controllers\Admin\ArticleController;
use App\Http\Controllers\Admin\NewsController;
use App\Http\Controllers\Student\StudentController;
use App\Http\Controllers\Teacher\TeacherDashboardController;
use App\Http\Controllers\Teacher\TeacherLessonController;
use App\Http\Controllers\QRCodeController;

// إضافة Controllers الواجهة العامة
use App\Http\Controllers\HomeController;
use App\Http\Controllers\CoursesController;
use App\Http\Controllers\LessonsController;
use App\Http\Controllers\ScholarsController;
use App\Http\Controllers\CategoriesController;

// إضافة Controllers لوحة التحكم - نظام الدورات
use App\Http\Controllers\Admin\ScholarController;
use App\Http\Controllers\Admin\CourseCategoryController;
use App\Http\Controllers\Admin\CourseController;
use App\Http\Controllers\Admin\CourseLessonController;

/*
|--------------------------------------------------------------------------
| الصفحات العامة للزوار (نظام إدارة الدورات)
|--------------------------------------------------------------------------
*/

// الصفحة الرئيسية
Route::get('/', [HomeController::class, 'index'])->name('home');
Route::get('/about', [HomeController::class, 'about'])->name('about');

// البحث العام
Route::get('/search', [HomeController::class, 'search'])->name('search');
Route::get('/advanced-search', [HomeController::class, 'advancedSearch'])->name('advanced-search');
Route::get('/search-suggestions', [HomeController::class, 'searchSuggestions'])->name('search.suggestions');

// الأقسام
Route::get('/categories', [CategoriesController::class, 'index'])->name('categories.index');
Route::get('/categories/{category}', [CategoriesController::class, 'show'])->name('categories.show');

// العلماء
Route::get('/scholars', [ScholarsController::class, 'index'])->name('scholars.index');
Route::get('/scholars/{scholar}', [ScholarsController::class, 'show'])->name('scholars.show');
Route::get('/scholars/specialization/{specialization}', [ScholarsController::class, 'specialization'])->name('scholars.specialization');
Route::get('/scholars/search', [ScholarsController::class, 'search'])->name('scholars.search');

// الدورات
Route::get('/courses', [CoursesController::class, 'index'])->name('courses.index');
Route::get('/courses/{course}', [CoursesController::class, 'show'])->name('courses.show');
Route::get('/courses/category/{category}', [CoursesController::class, 'category'])->name('courses.category');
Route::get('/courses/search', [CoursesController::class, 'search'])->name('courses.search');

// الدروس
Route::get('/lessons', [LessonsController::class, 'index'])->name('lessons.index');
Route::get('/courses/{course}/lessons/{lesson}', [LessonsController::class, 'show'])->name('lessons.show');
Route::post('/lessons/{lesson}/play', [LessonsController::class, 'play'])->name('lessons.play');
Route::get('/lessons/{lesson}/resource/{resourceIndex}', [LessonsController::class, 'downloadResource'])->name('lessons.download-resource');

/*
|--------------------------------------------------------------------------
| الصفحات الأصلية للمشروع
|--------------------------------------------------------------------------
*/

Route::get('/welcome-premium', function () {
    return view('welcome-premium');
})->name('welcome.premium');

Route::get('/welcome-simple', function () {
    return view('welcome-simple');
})->name('welcome.simple');

Route::get('/welcome-premium', function () {
    return view('welcome-premium');
})->name('welcome.premium');

// Legacy route for old welcome page
Route::get('/welcome-basmah', function () {
    return view('welcome-basmah');
});

// Student Registration Routes (Public - Students Only)
Route::middleware('guest')->group(function () {
    Route::get('/register', [StudentRegisterController::class, 'showRegistrationForm'])->name('student.register.form');
    Route::post('/register', [StudentRegisterController::class, 'register'])->name('student.register');
});

// Default login route redirects to admin login
Route::get('/login', function() {
    return redirect()->route('admin.login');
})->name('login');

// Admin Authentication Routes
Route::prefix('admin')->group(function () {
    Route::get('login', [AdminLoginController::class, 'showLoginForm'])->name('admin.login');
    Route::post('login', [AdminLoginController::class, 'login']);
    Route::post('logout', [AdminLoginController::class, 'logout'])->name('admin.logout');
    
    // Protected Admin Routes
    Route::middleware('admin')->group(function () {
        Route::get('dashboard', [DashboardController::class, 'index'])->name('admin.dashboard');
        
        // User Management Routes
        Route::resource('users', UserController::class)->names('admin.users');
        Route::get('teachers', [UserController::class, 'teachers'])->name('admin.users.teachers');
        Route::get('students', [UserController::class, 'students'])->name('admin.users.students');
        
        // Lesson Management Routes
        Route::resource('lessons', LessonController::class)->names('admin.lessons');
        
        // Attendance Routes (view and edit only - no creation)
        Route::get('attendances', [AttendanceController::class, 'index'])->name('admin.attendances.index');
        Route::get('attendances/{attendance}', [AttendanceController::class, 'show'])->name('admin.attendances.show');
        Route::get('attendances/{attendance}/edit', [AttendanceController::class, 'edit'])->name('admin.attendances.edit');
        Route::put('attendances/{attendance}', [AttendanceController::class, 'update'])->name('admin.attendances.update');
        Route::delete('attendances/{attendance}', [AttendanceController::class, 'destroy'])->name('admin.attendances.destroy');
        Route::get('attendances-reports', [AttendanceController::class, 'reports'])->name('admin.attendances.reports');
        Route::get('lessons/{lesson}/students', [AttendanceController::class, 'getStudents'])
            ->name('admin.lessons.students');
        Route::get('students/{student}/lessons', [AttendanceController::class, 'getStudentLessons'])
            ->name('admin.students.lessons');
        
        // QR Code Routes for Teachers/Admins
        Route::get('lessons/{lesson}/qr-display', [QRCodeController::class, 'displayQR'])
            ->name('admin.lessons.qr.display');
        Route::get('lessons/{lesson}/qr-info', [QRCodeController::class, 'getTokenInfo'])
            ->name('admin.lessons.qr.info');
        Route::post('lessons/{lesson}/qr-refresh', [QRCodeController::class, 'refreshToken'])
            ->name('admin.lessons.qr.refresh');
        
        // Book Management Routes
        Route::resource('books', BookController::class)->names('admin.books');
        Route::post('books/{book}/toggle-featured', [BookController::class, 'toggleFeatured'])
            ->name('admin.books.toggle-featured');
        Route::post('books/{book}/toggle-published', [BookController::class, 'togglePublished'])
            ->name('admin.books.toggle-published');
        Route::get('books/{book}/download', [BookController::class, 'download'])
            ->name('admin.books.download');
        
        // Article Management Routes
        Route::resource('articles', ArticleController::class)->names('admin.articles');
        Route::post('articles/{article}/toggle-featured', [ArticleController::class, 'toggleFeatured'])
            ->name('admin.articles.toggle-featured');
        Route::post('articles/{article}/toggle-published', [ArticleController::class, 'togglePublished'])
            ->name('admin.articles.toggle-published');
        Route::get('articles/{article}/preview', [ArticleController::class, 'preview'])
            ->name('admin.articles.preview');
        
        // News Management Routes
        Route::resource('news', NewsController::class)->names('admin.news');
        Route::post('news/{news}/toggle-featured', [NewsController::class, 'toggleFeatured'])
            ->name('admin.news.toggle-featured');
        Route::post('news/{news}/toggle-published', [NewsController::class, 'togglePublished'])
            ->name('admin.news.toggle-published');
        Route::get('news/{news}/preview', [NewsController::class, 'preview'])
            ->name('admin.news.preview');
        Route::get('news-urgent', [NewsController::class, 'urgent'])
            ->name('admin.news.urgent');
        Route::get('news-expired', [NewsController::class, 'expired'])
            ->name('admin.news.expired');
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
    
    // Teacher Attendance Management (view and edit only)
    Route::get('/teacher/attendances', [AttendanceController::class, 'index'])->name('teacher.attendances.index');
    Route::get('/teacher/attendances/lesson/{lesson}', [AttendanceController::class, 'lessonAttendance'])
        ->name('teacher.attendances.lesson');
    Route::get('/teacher/attendances/lesson/{lesson}/student/{student}', [AttendanceController::class, 'studentAttendance'])
        ->name('teacher.attendances.student');
    Route::put('/teacher/attendances/{attendance}', [AttendanceController::class, 'update'])->name('teacher.attendances.update');
    Route::get('/teacher/lessons/{lesson}/students', [TeacherLessonController::class, 'getStudents'])
        ->name('teacher.lessons.students');
    Route::get('/teacher/students/{student}/lessons', [TeacherLessonController::class, 'getStudentLessons'])
        ->name('teacher.students.lessons');
        
    // Teacher QR Code Routes (using admin routes)
    Route::get('/teacher/lessons/{lesson}/qr-display', [QRCodeController::class, 'displayQR'])
        ->name('teacher.lessons.qr.display');
    Route::get('/teacher/lessons/{lesson}/qr-info', [QRCodeController::class, 'getTokenInfo'])
        ->name('teacher.lessons.qr.info');
    Route::post('/teacher/lessons/{lesson}/qr-refresh', [QRCodeController::class, 'refreshToken'])
        ->name('teacher.lessons.qr.refresh');
});

// Student Routes
Route::middleware('student')->group(function () {
    Route::get('/student/dashboard', [StudentController::class, 'dashboard'])->name('student.dashboard');
    Route::get('/check-in', [StudentController::class, 'checkIn'])->name('student.checkin');
    
    // QR Code Scanner for Students
    Route::get('/qr-scanner', [QRCodeController::class, 'scanner'])->name('student.qr.scanner');
});

// Public QR Code Routes (accessible by both students and teachers)
Route::get('/qr-generate/{lesson}', [QRCodeController::class, 'generateQR'])->name('qr.generate');
Route::get('/attendance/scan', [QRCodeController::class, 'scanAttendance'])->name('attendance.scan');

/*
|--------------------------------------------------------------------------
| لوحة التحكم لإدارة نظام الدورات
|--------------------------------------------------------------------------
*/
Route::middleware(['admin'])->prefix('admin')->name('admin.')->group(function () {
    
    // إدارة العلماء
    Route::resource('scholars', \App\Http\Controllers\Admin\ScholarController::class);
    Route::post('scholars/{scholar}/toggle-status', [\App\Http\Controllers\Admin\ScholarController::class, 'toggleStatus'])
        ->name('scholars.toggle-status');
    Route::post('scholars/{scholar}/duplicate', [\App\Http\Controllers\Admin\ScholarController::class, 'duplicate'])
        ->name('scholars.duplicate');
    Route::get('scholars/{scholar}/courses', [\App\Http\Controllers\Admin\ScholarController::class, 'courses'])
        ->name('scholars.courses');
    
    // إدارة أقسام الدورات
    Route::resource('course-categories', \App\Http\Controllers\Admin\CourseCategoryController::class);
    Route::post('course-categories/{courseCategory}/toggle-status', [\App\Http\Controllers\Admin\CourseCategoryController::class, 'toggleStatus'])
        ->name('course-categories.toggle-status');
    Route::post('course-categories/{courseCategory}/duplicate', [\App\Http\Controllers\Admin\CourseCategoryController::class, 'duplicate'])
        ->name('course-categories.duplicate');
    Route::get('course-categories/{courseCategory}/courses', [\App\Http\Controllers\Admin\CourseCategoryController::class, 'courses'])
        ->name('course-categories.courses');
    
    // إدارة الدورات
    Route::resource('courses', \App\Http\Controllers\Admin\CourseController::class);
    Route::post('courses/{course}/toggle-status', [\App\Http\Controllers\Admin\CourseController::class, 'toggleStatus'])
        ->name('courses.toggle-status');
    Route::post('courses/{course}/duplicate', [\App\Http\Controllers\Admin\CourseController::class, 'duplicate'])
        ->name('courses.duplicate');
    Route::get('courses/{course}/lessons', [\App\Http\Controllers\Admin\CourseController::class, 'lessons'])
        ->name('courses.lessons');
    Route::post('courses/{course}/lessons/reorder', [\App\Http\Controllers\Admin\CourseController::class, 'reorderLessons'])
        ->name('courses.lessons.reorder');
    
    // إدارة الدروس
    Route::resource('course-lessons', \App\Http\Controllers\Admin\CourseLessonController::class);
    Route::post('course-lessons/{courseLesson}/toggle-status', [\App\Http\Controllers\Admin\CourseLessonController::class, 'toggleStatus'])
        ->name('course-lessons.toggle-status');
    Route::post('course-lessons/{courseLesson}/duplicate', [\App\Http\Controllers\Admin\CourseLessonController::class, 'duplicate'])
        ->name('course-lessons.duplicate');
    Route::post('course-lessons/reorder', [\App\Http\Controllers\Admin\CourseLessonController::class, 'reorder'])
        ->name('course-lessons.reorder');
    
    // إدارة الدروس مرتبطة بالدورات
    Route::prefix('courses/{course}')->name('courses.')->group(function () {
        Route::get('lessons/create', [\App\Http\Controllers\Admin\CourseLessonController::class, 'createForCourse'])
            ->name('lessons.create');
        Route::post('lessons', [\App\Http\Controllers\Admin\CourseLessonController::class, 'storeForCourse'])
            ->name('lessons.store');
        Route::get('lessons/{lesson}/edit', [\App\Http\Controllers\Admin\CourseLessonController::class, 'editForCourse'])
            ->name('lessons.edit');
        Route::put('lessons/{lesson}', [\App\Http\Controllers\Admin\CourseLessonController::class, 'updateForCourse'])
            ->name('lessons.update');
        Route::delete('lessons/{lesson}', [\App\Http\Controllers\Admin\CourseLessonController::class, 'destroyForCourse'])
            ->name('lessons.destroy');
    });
    
    // تقارير ونظرة عامة على نظام الدورات
    Route::get('courses-overview', function() {
        return view('admin.courses.overview');
    })->name('courses.overview');
});

// API Routes
Route::get('/api/lessons-simple', function() {
        return \App\Models\Lesson::select('id', 'name', 'subject', 'day_of_week', 'start_time')
            ->limit(20)
            ->get()
            ->map(function($lesson) {
                return [
                    'id' => $lesson->id,
                    'name' => $lesson->name,
                    'subject' => $lesson->subject,
                    'day_of_week' => $lesson->day_of_week,
                    'start_time' => $lesson->start_time ? $lesson->start_time->format('H:i') : 'غير محدد'
                ];
            });
    });
    
    Route::get('/qr-test-page', function() {
        return view('qr-test');
    })->name('qr.test.page');

// Testing Routes for QR Code (only in development)
if (env('APP_ENV') === 'local') {
    Route::get('/test-qr/{lesson}', function(\App\Models\Lesson $lesson) {
        try {
            // إجبار توليد QR Token
            $qrToken = $lesson->forceGenerateQRToken();
            
            // إنشاء QR Code
            $scanUrl = url("/attendance/scan?token=" . urlencode($qrToken->token));
            
            $qrCode = \SimpleSoftwareIO\QrCode\Facades\QrCode::format('svg')
                ->size(300)
                ->errorCorrection('H')
                ->generate($scanUrl);

            return response($qrCode)
                ->header('Content-Type', 'image/svg+xml');
                
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()], 500);
        }
    })->name('test.qr');
    
    Route::get('/quick-qr/{lesson}', [\App\Http\Controllers\QRCodeController::class, 'quickGenerate'])
        ->name('quick.qr');
}
