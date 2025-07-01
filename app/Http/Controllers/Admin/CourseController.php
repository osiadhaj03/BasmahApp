<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseCategory;
use App\Models\Scholar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CourseController extends Controller
{
    /**
     * Display a listing of courses
     */
    public function index(Request $request)
    {
        $query = Course::with(['category', 'scholar'])->withCount('lessons');

        // البحث
        if ($request->has('search') && $request->search) {
            $query->search($request->search);
        }

        // التصفية حسب القسم
        if ($request->has('category_id') && $request->category_id) {
            $query->byCategory($request->category_id);
        }

        // التصفية حسب العالم
        if ($request->has('scholar_id') && $request->scholar_id) {
            $query->byScholar($request->scholar_id);
        }

        // التصفية حسب المستوى
        if ($request->has('level') && $request->level) {
            $query->byLevel($request->level);
        }

        // التصفية حسب الحالة
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $courses = $query->ordered()->paginate(12);

        // للتصفية في الواجهة
        $categories = CourseCategory::active()->ordered()->get();
        $scholars = Scholar::active()->orderBy('name')->get();

        return view('admin.courses.index', compact('courses', 'categories', 'scholars'));
    }

    /**
     * Show the form for creating a new course
     */
    public function create()
    {
        $categories = CourseCategory::active()->ordered()->get();
        $scholars = Scholar::active()->orderBy('name')->get();

        return view('admin.courses.create', compact('categories', 'scholars'));
    }

    /**
     * Store a newly created course
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:course_categories,id',
            'scholar_id' => 'required|exists:scholars,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duration' => 'nullable|string|max:100',
            'level' => 'required|in:beginner,intermediate,advanced',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|boolean'
        ]);

        // رفع الصورة المصغرة إذا وجدت
        if ($request->hasFile('thumbnail')) {
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses', 'public');
        }

        // تعيين ترتيب تلقائي إذا لم يتم تحديده
        if (!isset($validated['sort_order'])) {
            $validated['sort_order'] = Course::max('sort_order') + 1;
        }

        $course = Course::create($validated);

        return redirect()->route('admin.courses.show', $course)
                        ->with('success', 'تم إضافة الدورة بنجاح');
    }

    /**
     * Display the specified course
     */
    public function show(Course $course)
    {
        $course->load([
            'category', 
            'scholar',
            'lessons' => function($query) {
                $query->ordered();
            }
        ]);

        return view('admin.courses.show', compact('course'));
    }

    /**
     * Show the form for editing the specified course
     */
    public function edit(Course $course)
    {
        $categories = CourseCategory::active()->ordered()->get();
        $scholars = Scholar::active()->orderBy('name')->get();

        return view('admin.courses.edit', compact('course', 'categories', 'scholars'));
    }

    /**
     * Update the specified course
     */
    public function update(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category_id' => 'required|exists:course_categories,id',
            'scholar_id' => 'required|exists:scholars,id',
            'thumbnail' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'duration' => 'nullable|string|max:100',
            'level' => 'required|in:beginner,intermediate,advanced',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|boolean'
        ]);

        // رفع الصورة المصغرة الجديدة إذا وجدت
        if ($request->hasFile('thumbnail')) {
            // حذف الصورة القديمة
            if ($course->thumbnail) {
                Storage::disk('public')->delete($course->thumbnail);
            }
            $validated['thumbnail'] = $request->file('thumbnail')->store('courses', 'public');
        }

        $course->update($validated);

        return redirect()->route('admin.courses.show', $course)
                        ->with('success', 'تم تحديث الدورة بنجاح');
    }

    /**
     * Remove the specified course
     */
    public function destroy(Course $course)
    {
        // حذف الصورة المصغرة
        if ($course->thumbnail) {
            Storage::disk('public')->delete($course->thumbnail);
        }

        // حذف الدورة (سيتم حذف الدروس تلقائياً بسبب cascade)
        $course->delete();

        return redirect()->route('admin.courses.index')
                        ->with('success', 'تم حذف الدورة وجميع دروسها بنجاح');
    }

    /**
     * Toggle course status
     */
    public function toggleStatus(Course $course)
    {
        $course->update(['status' => !$course->status]);

        $message = $course->status ? 'تم تفعيل الدورة' : 'تم إلغاء تفعيل الدورة';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Duplicate a course
     */
    public function duplicate(Course $course)
    {
        $newCourse = $course->replicate();
        $newCourse->title = $course->title . ' (نسخة)';
        $newCourse->status = false; // الدورة المنسوخة تكون معطلة بشكل افتراضي
        $newCourse->save();

        // نسخ الدروس
        foreach ($course->lessons as $lesson) {
            $newLesson = $lesson->replicate();
            $newLesson->course_id = $newCourse->id;
            $newLesson->save();
        }

        return redirect()->route('admin.courses.edit', $newCourse)
                        ->with('success', 'تم نسخ الدورة بنجاح، يمكنك الآن تعديلها');
    }

    /**
     * Get course statistics for dashboard
     */
    public function getStatistics()
    {
        $stats = [
            'total_courses' => Course::count(),
            'active_courses' => Course::active()->count(),
            'courses_by_category' => CourseCategory::withCount('courses')->get(),
            'courses_by_level' => Course::selectRaw('level, COUNT(*) as count')
                                       ->groupBy('level')
                                       ->get(),
            'recent_courses' => Course::with(['category', 'scholar'])
                                     ->latest()
                                     ->take(5)
                                     ->get()
        ];

        return response()->json($stats);
    }
}
