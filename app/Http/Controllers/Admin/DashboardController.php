<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scholar;
use App\Models\CourseCategory;
use App\Models\Course;
use App\Models\CourseLesson;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
    {
        // Gather statistics for all components
        $stats = [
            'scholars' => [
                'total' => Scholar::count(),
                'active' => Scholar::where('is_active', true)->count(),
                'inactive' => Scholar::where('is_active', false)->count(),
            ],
            'categories' => [
                'total' => CourseCategory::count(),
                'active' => CourseCategory::where('is_active', true)->count(),
                'inactive' => CourseCategory::where('is_active', false)->count(),
            ],
            'courses' => [
                'total' => Course::count(),
                'active' => Course::where('is_active', true)->count(),
                'inactive' => Course::where('is_active', false)->count(),
            ],
            'lessons' => [
                'total' => CourseLesson::count(),
                'active' => CourseLesson::where('is_active', true)->count(),
                'inactive' => CourseLesson::where('is_active', false)->count(),
            ]
        ];

        // Calculate total and active content
        $stats['total_content'] = $stats['scholars']['total'] + $stats['categories']['total'] + 
                                 $stats['courses']['total'] + $stats['lessons']['total'];
        $stats['active_content'] = $stats['scholars']['active'] + $stats['categories']['active'] + 
                                  $stats['courses']['active'] + $stats['lessons']['active'];

        // Get recent scholars
        $recentScholars = Scholar::withCount('courses')
            ->latest()
            ->take(5)
            ->get();

        // Get recent courses
        $recentCourses = Course::with('scholar')
            ->withCount('lessons')
            ->latest()
            ->take(5)
            ->get();

        // Get categories with course counts for statistics
        $categoriesStats = CourseCategory::withCount('courses')
            ->orderByDesc('courses_count')
            ->take(5)
            ->get();

        return view('admin.dashboard', compact(
            'stats',
            'recentScholars',
            'recentCourses',
            'categoriesStats'
        ));
    }
}
