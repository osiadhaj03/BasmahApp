<?php

namespace App\Http\Controllers;

use App\Models\Scholar;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\CourseCategory;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller لعرض صفحات العلماء والمؤلفين للزوار
 */
class ScholarsController extends Controller
{
    /**
     * عرض قائمة جميع العلماء
     */
    public function index(Request $request): View
    {
        $query = Scholar::query();

        // إظهار العلماء الذين لديهم دورات فقط (اختياري)
        if ($request->get('with_courses', true)) {
            $query->has('courses');
        }

        // البحث في الاسم والسيرة الذاتية
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('biography', 'like', '%' . $searchTerm . '%')
                  ->orWhere('specialization', 'like', '%' . $searchTerm . '%');
            });
        }

        // التصفية حسب التخصص
        if ($request->filled('specialization')) {
            $query->where('specialization', 'like', '%' . $request->specialization . '%');
        }

        // التصفية حسب فترة الحياة
        if ($request->filled('era')) {
            $era = $request->era;
            if ($era === 'contemporary') {
                // معاصرون (لا يوجد تاريخ وفاة أو وفاة بعد 1950)
                $query->where(function($q) {
                    $q->whereNull('death_date')
                      ->orWhere('death_date', '>', '1950-01-01');
                });
            } elseif ($era === 'classical') {
                // كلاسيكيون (وفاة قبل 1500)
                $query->where('death_date', '<', '1500-01-01');
            } elseif ($era === 'modern') {
                // حديثون (وفاة بين 1500-1950)
                $query->whereBetween('death_date', ['1500-01-01', '1950-01-01']);
            }
        }

        // الترتيب
        $sortBy = $request->get('sort', 'name');
        $sortDir = $request->get('direction', 'asc');
        
        $allowedSorts = ['name', 'birth_date', 'death_date', 'created_at'];
        if (in_array($sortBy, $allowedSorts)) {
            if ($sortBy === 'birth_date' || $sortBy === 'death_date') {
                $query->orderByRaw("$sortBy IS NULL, $sortBy $sortDir");
            } else {
                $query->orderBy($sortBy, $sortDir);
            }
        }

        // تحميل إحصائيات الدورات والدروس لكل عالم
        $scholars = $query->withCount(['courses', 'lessons'])->paginate(12);

        // إحصائيات عامة
        $stats = [
            'total_scholars' => Scholar::count(),
            'scholars_with_courses' => Scholar::has('courses')->count(),
            'total_courses' => Course::count(),
            'total_lessons' => CourseLesson::count(),
        ];

        // قائمة التخصصات المتاحة
        $specializations = Scholar::whereNotNull('specialization')
            ->distinct()
            ->pluck('specialization')
            ->filter()
            ->sort()
            ->values();

        return view('scholars.index', compact(
            'scholars',
            'stats',
            'specializations'
        ));
    }

    /**
     * عرض صفحة عالم واحد مع جميع إنتاجه
     */
    public function show(Scholar $scholar, Request $request): View
    {
        // تحميل الدورات مع إحصائيات
        $coursesQuery = $scholar->courses()
            ->where('is_active', true)
            ->with(['category', 'lessons'])
            ->withCount('lessons');

        // التصفية حسب القسم
        if ($request->filled('category')) {
            $coursesQuery->where('category_id', $request->category);
        }

        // التصفية حسب المستوى
        if ($request->filled('level')) {
            $coursesQuery->where('level', $request->level);
        }

        // الترتيب
        $sortBy = $request->get('sort', 'created_at');
        $sortDir = $request->get('direction', 'desc');
        
        $allowedSorts = ['created_at', 'title', 'lessons_count'];
        if (in_array($sortBy, $allowedSorts)) {
            if ($sortBy === 'lessons_count') {
                $coursesQuery->orderBy('lessons_count', $sortDir);
            } else {
                $coursesQuery->orderBy($sortBy, $sortDir);
            }
        }

        $courses = $coursesQuery->paginate(9);

        // أحدث الدروس للعالم
        $recentLessons = CourseLesson::whereHas('course', function($q) use ($scholar) {
            $q->where('scholar_id', $scholar->id)
              ->where('is_active', true);
        })
        ->where('is_active', true)
        ->with(['course'])
        ->orderBy('created_at', 'desc')
        ->limit(6)
        ->get();

        // إحصائيات العالم
        $stats = [
            'total_courses' => $scholar->courses()->where('is_active', true)->count(),
            'total_lessons' => $scholar->lessons()->where('is_active', true)->count(),
            'categories_count' => $scholar->courses()
                ->where('is_active', true)
                ->distinct('category_id')
                ->count(),
            'total_duration' => $scholar->courses()
                ->where('is_active', true)
                ->sum('duration') // بالدقائق
        ];

        // الأقسام التي يدرس فيها العالم للتصفية
        $categories = CourseCategory::whereHas('courses', function($q) use ($scholar) {
            $q->where('scholar_id', $scholar->id)
              ->where('is_active', true);
        })->orderBy('name')->get();

        // توزيع الدورات حسب الأقسام (للرسم البياني)
        $coursesDistribution = $scholar->courses()
            ->where('is_active', true)
            ->select('category_id', \DB::raw('count(*) as count'))
            ->with('category:id,name,color')
            ->groupBy('category_id')
            ->get()
            ->map(function($item) {
                return [
                    'category' => $item->category->name,
                    'count' => $item->count,
                    'color' => $item->category->color ?? '#3B82F6'
                ];
            });

        // علماء مشابهون (نفس التخصص)
        $relatedScholars = Scholar::where('id', '!=', $scholar->id)
            ->when($scholar->specialization, function($q) use ($scholar) {
                $q->where('specialization', 'like', '%' . $scholar->specialization . '%');
            })
            ->has('courses')
            ->withCount('courses')
            ->limit(6)
            ->get();

        return view('scholars.show', compact(
            'scholar',
            'courses',
            'recentLessons',
            'stats',
            'categories',
            'coursesDistribution',
            'relatedScholars'
        ));
    }

    /**
     * عرض الدورات حسب تخصص معين
     */
    public function specialization($specialization, Request $request): View
    {
        $scholars = Scholar::where('specialization', 'like', '%' . $specialization . '%')
            ->has('courses')
            ->withCount(['courses', 'lessons'])
            ->paginate(12);

        // إحصائيات التخصص
        $stats = [
            'scholars_count' => $scholars->total(),
            'total_courses' => Course::whereHas('scholar', function($q) use ($specialization) {
                $q->where('specialization', 'like', '%' . $specialization . '%');
            })->count(),
            'total_lessons' => CourseLesson::whereHas('course.scholar', function($q) use ($specialization) {
                $q->where('specialization', 'like', '%' . $specialization . '%');
            })->count(),
        ];

        return view('scholars.specialization', compact(
            'scholars',
            'specialization',
            'stats'
        ));
    }

    /**
     * البحث المتقدم في العلماء
     */
    public function search(Request $request): View
    {
        $query = Scholar::query();

        // البحث في الاسم والسيرة والتخصص
        if ($request->filled('q')) {
            $searchTerm = $request->q;
            $query->where(function($q) use ($searchTerm) {
                $q->where('name', 'like', '%' . $searchTerm . '%')
                  ->orWhere('biography', 'like', '%' . $searchTerm . '%')
                  ->orWhere('specialization', 'like', '%' . $searchTerm . '%');
            });
        }

        // البحث في دورات العالم
        if ($request->filled('course_search')) {
            $query->whereHas('courses', function($q) use ($request) {
                $q->where('title', 'like', '%' . $request->course_search . '%')
                  ->orWhere('description', 'like', '%' . $request->course_search . '%');
            });
        }

        // التصفية حسب وجود دورات
        if ($request->get('has_courses', true)) {
            $query->has('courses');
        }

        $scholars = $query->withCount(['courses', 'lessons'])
            ->orderBy('name')
            ->paginate(12);

        return view('scholars.search', compact('scholars'));
    }
}
