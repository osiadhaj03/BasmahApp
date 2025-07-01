<?php

namespace App\Http\Controllers;

use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\CourseCategory;
use App\Models\Scholar;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller للصفحة الرئيسية والبحث العام
 */
class HomeController extends Controller
{
    /**
     * الصفحة الرئيسية
     */
    public function index(): View
    {
        // أحدث الدورات
        $latestCourses = Course::active()
            ->with(['category', 'scholar', 'lessons'])
            ->withCount('lessons')
            ->orderBy('created_at', 'desc')
            ->limit(8)
            ->get();

        // الدورات الأكثر شعبية (حسب عدد الدروس)
        $popularCourses = Course::active()
            ->with(['category', 'scholar'])
            ->withCount('lessons')
            ->orderBy('lessons_count', 'desc')
            ->limit(6)
            ->get();

        // أحدث الدروس
        $latestLessons = CourseLesson::active()
            ->with(['course.category', 'course.scholar'])
            ->orderBy('created_at', 'desc')
            ->limit(6)
            ->get();

        // الأقسام مع إحصائياتها
        $categories = CourseCategory::withCount([
            'courses' => function($q) {
                $q->where('is_active', true);
            },
            'lessons' => function($q) {
                $q->whereHas('course', function($cq) {
                    $cq->where('is_active', true);
                });
            }
        ])
        ->having('courses_count', '>', 0)
        ->orderBy('courses_count', 'desc')
        ->limit(8)
        ->get();

        // أبرز العلماء
        $featuredScholars = Scholar::has('courses')
            ->withCount(['courses', 'lessons'])
            ->orderBy('courses_count', 'desc')
            ->limit(6)
            ->get();

        // إحصائيات عامة للموقع
        $stats = [
            'total_courses' => Course::active()->count(),
            'total_lessons' => CourseLesson::active()->count(),
            'total_categories' => CourseCategory::has('courses')->count(),
            'total_scholars' => Scholar::has('courses')->count(),
            'total_duration' => Course::active()->sum('duration'), // بالدقائق
        ];

        return view('home', compact(
            'latestCourses',
            'popularCourses',
            'latestLessons',
            'categories',
            'featuredScholars',
            'stats'
        ));
    }

    /**
     * البحث العام في الموقع
     */
    public function search(Request $request): View
    {
        $searchTerm = $request->get('q', '');
        $type = $request->get('type', 'all'); // all, courses, lessons, scholars, categories
        
        $results = [
            'courses' => collect(),
            'lessons' => collect(),
            'scholars' => collect(),
            'categories' => collect(),
        ];

        if (!empty($searchTerm)) {
            // البحث في الدورات
            if ($type === 'all' || $type === 'courses') {
                $results['courses'] = Course::active()
                    ->where(function($q) use ($searchTerm) {
                        $q->where('title', 'like', '%' . $searchTerm . '%')
                          ->orWhere('description', 'like', '%' . $searchTerm . '%');
                    })
                    ->with(['category', 'scholar'])
                    ->withCount('lessons')
                    ->limit(10)
                    ->get();
            }

            // البحث في الدروس
            if ($type === 'all' || $type === 'lessons') {
                $results['lessons'] = CourseLesson::active()
                    ->where(function($q) use ($searchTerm) {
                        $q->where('title', 'like', '%' . $searchTerm . '%')
                          ->orWhere('description', 'like', '%' . $searchTerm . '%')
                          ->orWhere('content', 'like', '%' . $searchTerm . '%');
                    })
                    ->with(['course.category', 'course.scholar'])
                    ->limit(10)
                    ->get();
            }

            // البحث في العلماء
            if ($type === 'all' || $type === 'scholars') {
                $results['scholars'] = Scholar::where(function($q) use ($searchTerm) {
                        $q->where('name', 'like', '%' . $searchTerm . '%')
                          ->orWhere('biography', 'like', '%' . $searchTerm . '%')
                          ->orWhere('specialization', 'like', '%' . $searchTerm . '%');
                    })
                    ->has('courses')
                    ->withCount(['courses', 'lessons'])
                    ->limit(10)
                    ->get();
            }

            // البحث في الأقسام
            if ($type === 'all' || $type === 'categories') {
                $results['categories'] = CourseCategory::where(function($q) use ($searchTerm) {
                        $q->where('name', 'like', '%' . $searchTerm . '%')
                          ->orWhere('description', 'like', '%' . $searchTerm . '%');
                    })
                    ->has('courses')
                    ->withCount('courses')
                    ->limit(8)
                    ->get();
            }
        }

        // حساب العدد الإجمالي للنتائج
        $totalResults = $results['courses']->count() + 
                       $results['lessons']->count() + 
                       $results['scholars']->count() + 
                       $results['categories']->count();

        return view('search', compact(
            'searchTerm',
            'type',
            'results',
            'totalResults'
        ));
    }

    /**
     * البحث المتقدم
     */
    public function advancedSearch(Request $request): View
    {
        $filters = $request->only([
            'title', 'description', 'category', 'scholar', 
            'level', 'duration_min', 'duration_max', 'content_type'
        ]);

        $query = Course::active()
            ->with(['category', 'scholar'])
            ->withCount('lessons');

        // البحث في العنوان
        if (!empty($filters['title'])) {
            $query->where('title', 'like', '%' . $filters['title'] . '%');
        }

        // البحث في الوصف
        if (!empty($filters['description'])) {
            $query->where('description', 'like', '%' . $filters['description'] . '%');
        }

        // التصفية حسب القسم
        if (!empty($filters['category'])) {
            $query->where('category_id', $filters['category']);
        }

        // التصفية حسب العالم
        if (!empty($filters['scholar'])) {
            $query->where('scholar_id', $filters['scholar']);
        }

        // التصفية حسب المستوى
        if (!empty($filters['level'])) {
            $query->where('level', $filters['level']);
        }

        // التصفية حسب المدة
        if (!empty($filters['duration_min'])) {
            $query->where('duration', '>=', $filters['duration_min']);
        }
        if (!empty($filters['duration_max'])) {
            $query->where('duration', '<=', $filters['duration_max']);
        }

        // التصفية حسب نوع المحتوى
        if (!empty($filters['content_type'])) {
            $contentType = $filters['content_type'];
            if ($contentType === 'video') {
                $query->whereHas('lessons', function($q) {
                    $q->whereNotNull('video_url');
                });
            } elseif ($contentType === 'audio') {
                $query->whereHas('lessons', function($q) {
                    $q->whereNotNull('audio_url');
                });
            }
        }

        $courses = $query->paginate(12);

        // البيانات المساعدة للفلاتر
        $categories = CourseCategory::has('courses')->orderBy('name')->get();
        $scholars = Scholar::has('courses')->orderBy('name')->get();

        return view('advanced-search', compact(
            'courses',
            'categories',
            'scholars',
            'filters'
        ));
    }

    /**
     * اقتراحات البحث (Ajax)
     */
    public function searchSuggestions(Request $request)
    {
        $term = $request->get('term', '');
        
        if (strlen($term) < 2) {
            return response()->json([]);
        }

        $suggestions = [];

        // اقتراحات من عناوين الدورات
        $courses = Course::active()
            ->where('title', 'like', '%' . $term . '%')
            ->select('title')
            ->limit(5)
            ->get()
            ->map(function($course) {
                return [
                    'value' => $course->title,
                    'label' => $course->title,
                    'type' => 'course'
                ];
            });

        // اقتراحات من أسماء العلماء
        $scholars = Scholar::where('name', 'like', '%' . $term . '%')
            ->select('name')
            ->limit(5)
            ->get()
            ->map(function($scholar) {
                return [
                    'value' => $scholar->name,
                    'label' => $scholar->name,
                    'type' => 'scholar'
                ];
            });

        // اقتراحات من أسماء الأقسام
        $categories = CourseCategory::where('name', 'like', '%' . $term . '%')
            ->select('name')
            ->limit(3)
            ->get()
            ->map(function($category) {
                return [
                    'value' => $category->name,
                    'label' => $category->name,
                    'type' => 'category'
                ];
            });

        $suggestions = $courses->concat($scholars)->concat($categories);

        return response()->json($suggestions->toArray());
    }

    /**
     * صفحة حول الموقع
     */
    public function about(): View
    {
        // إحصائيات مفصلة
        $stats = [
            'courses' => [
                'total' => Course::active()->count(),
                'by_level' => Course::active()
                    ->selectRaw('level, COUNT(*) as count')
                    ->groupBy('level')
                    ->pluck('count', 'level'),
                'by_category' => Course::active()
                    ->with('category:id,name')
                    ->get()
                    ->groupBy('category.name')
                    ->map(function($courses) {
                        return $courses->count();
                    })
            ],
            'lessons' => [
                'total' => CourseLesson::active()->count(),
                'total_duration' => CourseLesson::active()->sum('duration'),
                'with_video' => CourseLesson::active()->whereNotNull('video_url')->count(),
                'with_audio' => CourseLesson::active()->whereNotNull('audio_url')->count(),
            ],
            'scholars' => [
                'total' => Scholar::has('courses')->count(),
                'by_specialization' => Scholar::has('courses')
                    ->whereNotNull('specialization')
                    ->selectRaw('specialization, COUNT(*) as count')
                    ->groupBy('specialization')
                    ->pluck('count', 'specialization')
            ]
        ];

        return view('about', compact('stats'));
    }
}
