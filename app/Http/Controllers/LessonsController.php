<?php

namespace App\Http\Controllers;

use App\Models\CourseLesson;
use App\Models\Course;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller لعرض تفاصيل الدروس للزوار
 */
class LessonsController extends Controller
{
    /**
     * عرض تفاصيل درس واحد مع الفيديو والمعلومات
     */
    public function show(Course $course, CourseLesson $lesson): View
    {
        // التأكد من أن الدورة والدرس نشطان
        if (!$course->is_active || !$lesson->is_active) {
            abort(404);
        }

        // التأكد من أن الدرس ينتمي للدورة
        if ($lesson->course_id !== $course->id) {
            abort(404);
        }

        // تحميل العلاقات المطلوبة
        $course->load(['category', 'scholar']);
        
        // الحصول على الدرس السابق والتالي
        $previousLesson = $lesson->getPreviousLesson();
        $nextLesson = $lesson->getNextLesson();

        // الحصول على جميع دروس الدورة للقائمة الجانبية
        $courseLessons = CourseLesson::where('course_id', $course->id)
            ->where('is_active', true)
            ->orderBy('order_number', 'asc')
            ->orderBy('created_at', 'asc')
            ->get();

        // تحديد الدرس الحالي في القائمة
        $currentLessonIndex = $courseLessons->search(function($item) use ($lesson) {
            return $item->id === $lesson->id;
        });

        // إحصائيات للعرض
        $stats = [
            'current_lesson_number' => $currentLessonIndex !== false ? $currentLessonIndex + 1 : 1,
            'total_lessons' => $courseLessons->count(),
            'completion_percentage' => $courseLessons->count() > 0 
                ? round((($currentLessonIndex + 1) / $courseLessons->count()) * 100)
                : 0
        ];

        // دروس مقترحة من نفس القسم
        $suggestedLessons = CourseLesson::whereHas('course', function($q) use ($course) {
            $q->where('category_id', $course->category_id)
              ->where('id', '!=', $course->id)
              ->where('is_active', true);
        })
        ->where('is_active', true)
        ->with(['course.scholar', 'course.category'])
        ->limit(6)
        ->get();

        return view('lessons.show', compact(
            'lesson',
            'course',
            'previousLesson',
            'nextLesson',
            'courseLessons',
            'stats',
            'suggestedLessons'
        ));
    }

    /**
     * عرض قائمة جميع الدروس (للبحث العام)
     */
    public function index(Request $request): View
    {
        $query = CourseLesson::active()
            ->with(['course.category', 'course.scholar']);

        // البحث في العنوان والوصف
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('course', function($cq) use ($searchTerm) {
                      $cq->where('title', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // التصفية حسب الدورة
        if ($request->filled('course')) {
            $query->where('course_id', $request->course);
        }

        // التصفية حسب القسم
        if ($request->filled('category')) {
            $query->whereHas('course', function($q) use ($request) {
                $q->where('category_id', $request->category);
            });
        }

        // التصفية حسب العالم
        if ($request->filled('scholar')) {
            $query->whereHas('course', function($q) use ($request) {
                $q->where('scholar_id', $request->scholar);
            });
        }

        // التصفية حسب نوع المحتوى
        if ($request->filled('content_type')) {
            $contentType = $request->content_type;
            if ($contentType === 'video') {
                $query->whereNotNull('video_url');
            } elseif ($contentType === 'audio') {
                $query->whereNotNull('audio_url');
            } elseif ($contentType === 'text') {
                $query->whereNotNull('content');
            } elseif ($contentType === 'pdf') {
                $query->where('additional_resources', 'like', '%"type":"pdf"%');
            }
        }

        // الترتيب
        $sortBy = $request->get('sort', 'created_at');
        $sortDir = $request->get('direction', 'desc');
        
        $allowedSorts = ['created_at', 'title', 'duration', 'order_number'];
        if (in_array($sortBy, $allowedSorts)) {
            $query->orderBy($sortBy, $sortDir);
        }

        $lessons = $query->paginate(15);

        // البيانات المساعدة للتصفية
        $courses = Course::active()
            ->has('lessons')
            ->orderBy('title')
            ->get();

        $categories = \App\Models\CourseCategory::whereHas('courses.lessons')
            ->orderBy('name')
            ->get();

        $scholars = \App\Models\Scholar::whereHas('courses.lessons')
            ->orderBy('name')
            ->get();

        return view('lessons.index', compact(
            'lessons',
            'courses',
            'categories',
            'scholars'
        ));
    }

    /**
     * تشغيل الفيديو (Ajax endpoint)
     */
    public function play(CourseLesson $lesson)
    {
        // التأكد من أن الدرس نشط
        if (!$lesson->is_active || !$lesson->course->is_active) {
            return response()->json(['error' => 'الدرس غير متاح'], 404);
        }

        // إرجاع بيانات الفيديو
        return response()->json([
            'video_url' => $lesson->video_embed_url,
            'title' => $lesson->title,
            'description' => $lesson->description,
            'duration' => $lesson->formatted_duration,
        ]);
    }

    /**
     * تحميل الموارد الإضافية
     */
    public function downloadResource(CourseLesson $lesson, $resourceIndex)
    {
        // التأكد من أن الدرس نشط
        if (!$lesson->is_active || !$lesson->course->is_active) {
            abort(404);
        }

        $resources = $lesson->additional_resources ?? [];
        
        if (!isset($resources[$resourceIndex])) {
            abort(404);
        }

        $resource = $resources[$resourceIndex];
        
        // التأكد من وجود الملف
        if (isset($resource['file_path']) && file_exists(storage_path('app/public/' . $resource['file_path']))) {
            return response()->download(
                storage_path('app/public/' . $resource['file_path']),
                $resource['title'] ?? 'resource.pdf'
            );
        }

        abort(404);
    }
}
