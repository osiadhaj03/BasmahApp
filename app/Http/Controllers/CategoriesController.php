<?php

namespace App\Http\Controllers;

use App\Models\CourseCategory;
use App\Models\Course;
use App\Models\CourseLesson;
use App\Models\Scholar;
use Illuminate\Http\Request;
use Illuminate\View\View;

/**
 * Controller لعرض أقسام الدورات للزوار
 */
class CategoriesController extends Controller
{
    /**
     * عرض جميع أقسام الدورات
     */
    public function index(): View
    {
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
        ->orderBy('name')
        ->get();

        // إحصائيات عامة
        $stats = [
            'total_categories' => $categories->count(),
            'total_courses' => Course::where('is_active', true)->count(),
            'total_lessons' => CourseLesson::whereHas('course', function($q) {
                $q->where('is_active', true);
            })->count(),
            'total_scholars' => Scholar::has('courses')->count(),
        ];

        return view('categories.index', compact('categories', 'stats'));
    }

    /**
     * عرض قسم واحد مع دوراته
     */
    public function show(CourseCategory $category, Request $request): View
    {
        $coursesQuery = $category->courses()
            ->where('is_active', true)
            ->with(['scholar', 'lessons'])
            ->withCount('lessons');

        // التصفية حسب العالم
        if ($request->filled('scholar')) {
            $coursesQuery->where('scholar_id', $request->scholar);
        }

        // التصفية حسب المستوى
        if ($request->filled('level')) {
            $coursesQuery->where('level', $request->level);
        }

        // البحث
        if ($request->filled('search')) {
            $searchTerm = $request->search;
            $coursesQuery->where(function($q) use ($searchTerm) {
                $q->where('title', 'like', '%' . $searchTerm . '%')
                  ->orWhere('description', 'like', '%' . $searchTerm . '%');
            });
        }

        // الترتيب
        $sortBy = $request->get('sort', 'created_at');
        $sortDir = $request->get('direction', 'desc');
        
        $allowedSorts = ['created_at', 'title', 'lessons_count', 'duration'];
        if (in_array($sortBy, $allowedSorts)) {
            if ($sortBy === 'lessons_count') {
                $coursesQuery->orderBy('lessons_count', $sortDir);
            } else {
                $coursesQuery->orderBy($sortBy, $sortDir);
            }
        }

        $courses = $coursesQuery->paginate(12);

        // العلماء المتخصصون في هذا القسم
        $scholars = Scholar::whereHas('courses', function($q) use ($category) {
            $q->where('category_id', $category->id)
              ->where('is_active', true);
        })
        ->withCount(['courses' => function($q) use ($category) {
            $q->where('category_id', $category->id)
              ->where('is_active', true);
        }])
        ->orderBy('name')
        ->get();

        // أحدث الدروس في هذا القسم
        $recentLessons = CourseLesson::whereHas('course', function($q) use ($category) {
            $q->where('category_id', $category->id)
              ->where('is_active', true);
        })
        ->where('is_active', true)
        ->with(['course.scholar'])
        ->orderBy('created_at', 'desc')
        ->limit(6)
        ->get();

        // إحصائيات القسم
        $stats = [
            'total_courses' => $category->courses()->where('is_active', true)->count(),
            'total_lessons' => CourseLesson::whereHas('course', function($q) use ($category) {
                $q->where('category_id', $category->id)
                  ->where('is_active', true);
            })->count(),
            'scholars_count' => $scholars->count(),
            'avg_duration' => $category->courses()
                ->where('is_active', true)
                ->avg('duration'),
        ];

        // أقسام مشابهة
        $relatedCategories = CourseCategory::where('id', '!=', $category->id)
            ->has('courses')
            ->withCount('courses')
            ->limit(4)
            ->get();

        return view('categories.show', compact(
            'category',
            'courses',
            'scholars',
            'recentLessons',
            'stats',
            'relatedCategories'
        ));
    }
}
