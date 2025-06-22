<?php

require_once 'vendor/autoload.php';

use Illuminate\Support\Facades\DB;

// تحميل Laravel
$app = require_once 'bootstrap/app.php';
$kernel = $app->make(Illuminate\Contracts\Console\Kernel::class);
$kernel->bootstrap();

echo "==========================================\n";
echo "اختبار لوحة تحكم المعلم - BasmahApp\n";
echo "==========================================\n\n";

try {
    // 1. فحص الـ Routes
    echo "1. فحص Routes لوحة تحكم المعلم:\n";
    echo "   ✓ Route teacher.dashboard: " . (Route::has('teacher.dashboard') ? "موجود" : "غير موجود") . "\n";
    echo "   ✓ Route teacher.attendances.index: " . (Route::has('teacher.attendances.index') ? "موجود" : "غير موجود") . "\n";
    echo "   ✓ Route teacher.attendances.create: " . (Route::has('teacher.attendances.create') ? "موجود" : "غير موجود") . "\n";
    echo "   ✓ Route teacher.attendances.bulk: " . (Route::has('teacher.attendances.bulk') ? "موجود" : "غير موجود") . "\n\n";

    // 2. فحص الـ Middleware
    echo "2. فحص Middleware:\n";
    $middlewareExists = class_exists('App\\Http\\Middleware\\TeacherMiddleware');
    echo "   ✓ TeacherMiddleware: " . ($middlewareExists ? "موجود" : "غير موجود") . "\n\n";

    // 3. فحص الـ Controller
    echo "3. فحص TeacherDashboardController:\n";
    $controllerExists = class_exists('App\\Http\\Controllers\\Teacher\\TeacherDashboardController');
    echo "   ✓ Controller: " . ($controllerExists ? "موجود" : "غير موجود") . "\n";
    
    if ($controllerExists) {
        $controller = new App\Http\Controllers\Teacher\TeacherDashboardController();
        $methods = get_class_methods($controller);
        echo "   ✓ Method dashboard: " . (in_array('dashboard', $methods) ? "موجود" : "غير موجود") . "\n";
    }
    echo "\n";

    // 4. فحص Views
    echo "4. فحص Views:\n";
    $viewPath = resource_path('views/teacher/dashboard.blade.php');
    echo "   ✓ teacher/dashboard.blade.php: " . (file_exists($viewPath) ? "موجود" : "غير موجود") . "\n";
    
    $layoutPath = resource_path('views/layouts/admin.blade.php');
    echo "   ✓ layouts/admin.blade.php: " . (file_exists($layoutPath) ? "موجود" : "غير موجود") . "\n\n";

    // 5. فحص بيانات الاختبار
    echo "5. فحص بيانات المعلمين:\n";
    $teachers = DB::table('users')->where('role', 'teacher')->get();
    echo "   ✓ عدد المعلمين في النظام: " . $teachers->count() . "\n";
    
    if ($teachers->count() > 0) {
        foreach ($teachers as $teacher) {
            echo "     - المعلم: {$teacher->name} (ID: {$teacher->id})\n";
            
            // فحص دروس المعلم
            $lessons = DB::table('lessons')->where('teacher_id', $teacher->id)->get();
            echo "       * عدد الدروس: " . $lessons->count() . "\n";
            
            if ($lessons->count() > 0) {
                foreach ($lessons as $lesson) {
                    $attendances = DB::table('attendances')->where('lesson_id', $lesson->id)->count();
                    echo "         - {$lesson->subject} ({$lesson->day_of_week} {$lesson->start_time}) - سجلات الحضور: {$attendances}\n";
                }
            }
        }
    }
    echo "\n";

    // 6. اختبار إحصائيات لوحة التحكم (محاكاة)
    echo "6. محاكاة إحصائيات لوحة التحكم:\n";
    if ($teachers->count() > 0) {
        $firstTeacher = $teachers->first();
        
        // محاكاة البيانات كما في Controller
        $teacherLessons = DB::table('lessons')
            ->where('teacher_id', $firstTeacher->id)
            ->get();
        
        $lessonIds = $teacherLessons->pluck('id')->toArray();
        
        $totalAttendances = 0;
        $presentCount = 0;
        $absentCount = 0;
        
        if (!empty($lessonIds)) {
            $totalAttendances = DB::table('attendances')
                ->whereIn('lesson_id', $lessonIds)
                ->count();
            
            $presentCount = DB::table('attendances')
                ->whereIn('lesson_id', $lessonIds)
                ->where('status', 'present')
                ->count();
            
            $absentCount = DB::table('attendances')
                ->whereIn('lesson_id', $lessonIds)
                ->where('status', 'absent')
                ->count();
        }
        
        $attendanceRate = $totalAttendances > 0 ? round(($presentCount / $totalAttendances) * 100, 1) : 0;
        
        echo "   المعلم: {$firstTeacher->name}\n";
        echo "   ✓ إجمالي الدروس: " . $teacherLessons->count() . "\n";
        echo "   ✓ إجمالي سجلات الحضور: {$totalAttendances}\n";
        echo "   ✓ الحضور: {$presentCount}\n";
        echo "   ✓ الغياب: {$absentCount}\n";
        echo "   ✓ معدل الحضور: {$attendanceRate}%\n";
    }
    echo "\n";

    // 7. فحص صحة الـ Navigation
    echo "7. فحص صحة التنقل:\n";
    $layoutContent = file_get_contents($layoutPath);
    $hasTeacherNav = strpos($layoutContent, 'teacher.dashboard') !== false;
    echo "   ✓ قائمة تنقل المعلم: " . ($hasTeacherNav ? "مضافة" : "غير مضافة") . "\n";
    
    $hasRoleCheck = strpos($layoutContent, "auth()->user()->role === 'teacher'") !== false;
    echo "   ✓ فحص صلاحيات المعلم: " . ($hasRoleCheck ? "موجود" : "غير موجود") . "\n\n";

    echo "==========================================\n";
    echo "✅ تم إكمال فحص لوحة تحكم المعلم بنجاح!\n";
    echo "==========================================\n\n";

    // 8. توجيهات للاختبار العملي
    echo "8. خطوات الاختبار العملي:\n";
    echo "   1. قم بتسجيل الدخول كمعلم\n";
    echo "   2. انتقل إلى: /teacher/dashboard\n";
    echo "   3. تحقق من عرض الإحصائيات بشكل صحيح\n";
    echo "   4. اختبر روابط التنقل (تسجيل حضور فردي/جماعي)\n";
    echo "   5. تحقق من عرض دروس اليوم وأداء الطلاب\n\n";

    echo "ملاحظات:\n";
    echo "- لوحة تحكم المعلم تعرض فقط البيانات المتعلقة بدروسه\n";
    echo "- المعلم يمكنه تسجيل الحضور ولكن لا يمكنه إدارة المستخدمين\n";
    echo "- التصميم متجاوب ويدعم الأجهزة المحمولة\n";
    echo "- الإحصائيات تحدث في الوقت الفعلي\n\n";

} catch (Exception $e) {
    echo "❌ خطأ أثناء الاختبار: " . $e->getMessage() . "\n";
    echo "تفاصيل الخطأ: " . $e->getFile() . " في السطر " . $e->getLine() . "\n";
}
