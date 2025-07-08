<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Scholar;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller للصفحات العامة - عرض الدورات للزوار
 */
class CoursesController extends Controller
{
    /**
     * عرض جميع الدورات مع التصنيف حسب الأقسام
     */
    public function index(Request $request): View
    {
        $query = Course::active()
            ->with(['category', 'scholar', 'lessons'])
            ->withCount('lessons');

        // التصفية حسب القسم
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // التصفية حسب العالم
        if ($request->filled('scholar')) {
            $query->where('scholar_id', $request->scholar);
        }

        // التصفية حسب المستوى
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // البحث في العنوان والوصف
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // الترتيب
        $sortBy = $request->get('sort', 'created_at');
        $sortDir = $request->get('direction', 'desc');
        
        $allowedSorts = ['created_at', 'title', 'lessons_count', 'duration'];
        if (in_array($sortBy, $allowedSorts)) {
            if ($sortBy === 'lessons_count') {
                $query->orderBy('lessons_count', $sortDir);
            } else {
                $query->orderBy($sortBy, $sortDir);
            }
        }

        $courses = $query->paginate(12);

        // الحصول على جميع الأقسام للتصفية
        $categories = CourseCategory::orderBy('name')->get();
        
        // الحصول على العلماء للتصفية
        $scholars = Scholar::has('courses')
            ->orderBy('name')
            ->get();

        // إحصائيات للعرض
        $stats = [
            'total_courses' => Course::active()->count(),
            'total_lessons' => \App\Models\CourseLesson::whereHas('course', function($q) {
                $q->where('is_active', true);
            })->count(),
            'total_categories' => CourseCategory::count(),
            'total_scholars' => Scholar::has('courses')->count(),
        ];

        return view('courses.index', compact(
            'courses', 
            'categories', 
            'scholars', 
            'stats'
        ));
    }

    /**
     * عرض دورة واحدة مع قائمة دروسها
     */
    public function show(Course $course): View
    {
        // التأكد من أن الدورة نشطة
        if (!$course->is_active) {
            abort(404);
        }

        // تحميل العلاقات المطلوبة
        $course->load([
            'category',
            'scholar',
            'lessons' => function($query) {
                $query->orderBy('order_number', 'asc')
                      ->orderBy('created_at', 'asc');
            }
        ]);

        // الحصول على دورات أخرى من نفس القسم
        $relatedCourses = Course::active()
            ->where('category_id', $course->category_id)
            ->where('id', '!=', $course->id)
            ->with(['category', 'scholar'])
            ->withCount('lessons')
            ->limit(6)
            ->get();

        // الحصول على دورات أخرى لنفس العالم
        $scholarCourses = Course::active()
            ->where('scholar_id', $course->scholar_id)
            ->where('id', '!=', $course->id)
            ->with(['category'])
            ->withCount('lessons')
            ->limit(4)
            ->get();

        return view('courses.show', compact(
            'course', 
            'relatedCourses', 
            'scholarCourses'
        ));
    }

    /**
     * عرض الدورات حسب قسم معين
     */
    public function category(CourseCategory $category, Request $request): View
    {
        $query = Course::active()
            ->where('category_id', $category->id)
            ->with(['scholar', 'lessons'])
            ->withCount('lessons');

        // البحث
        if ($request->filled('search')) {
            $query->where(function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->search . '%')
                  ->orWhere('description', 'like', '%' . $request->search . '%');
            });
        }

        // التصفية حسب العالم
        if ($request->filled('scholar')) {
            $query->where('scholar_id', $request->scholar);
        }

        // التصفية حسب المستوى
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // الترتيب
        $sortBy = $request->get('sort', 'created_at');
        $sortDir = $request->get('direction', 'desc');
        
        $allowedSorts = ['created_at', 'title', 'lessons_count', 'duration'];
        if (in_array($sortBy, $allowedSorts)) {
            if ($sortBy === 'lessons_count') {
                $query->orderBy('lessons_count', $sortDir);
            } else {
                $query->orderBy($sortBy, $sortDir);
            }
        }

        $courses = $query->paginate(12);

        // العلماء في هذا القسم للتصفية
        $scholars = Scholar::whereHas('courses', function($q) use ($category) {
            $q->where('category_id', $category->id)
              ->where('is_active', true);
        })->orderBy('name')->get();

        return view('courses.category', compact(
            'category', 
            'courses', 
            'scholars'
        ));
    }

    /**
     * البحث المتقدم في الدورات
     */
    public function search(Request $request): View
    {
        $query = Course::active()
            ->with(['category', 'scholar', 'lessons'])
            ->withCount('lessons');

        // البحث في العنوان والوصف
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%')
                  ->orWhereHas('scholar', function($sq) use ($searchTerm) {
                      $sq->where('name', 'like', '%' . $searchTerm . '%');
                  })
                  ->orWhereHas('category', function($cq) use ($searchTerm) {
                      $cq->where('name', 'like', '%' . $searchTerm . '%');
                  });
            });
        }

        // التصفية حسب القسم
        if ($request->filled('category')) {
            $query->where('category_id', $request->category);
        }

        // التصفية حسب العالم
        if ($request->filled('scholar')) {
            $query->where('scholar_id', $request->scholar);
        }

        // التصفية حسب المستوى
        if ($request->filled('level')) {
            $query->where('level', $request->level);
        }

        // الترتيب
        $sortBy = $request->get('sort', 'created_at');
        $sortDir = $request->get('direction', 'desc');
        
        $courses = $query->orderBy($sortBy, $sortDir)->paginate(12);

        // البيانات المساعدة للتصفية
        $categories = CourseCategory::orderBy('name')->get();
        $scholars = Scholar::has('courses')->orderBy('name')->get();

        return view('courses.search', compact(
            'courses', 
            'categories', 
            'scholars'
        ));
    }
}
