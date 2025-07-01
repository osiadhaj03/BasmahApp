<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Course;
use App\Models\CourseLesson;
use Illuminate\Http\Request;

class CourseLessonController extends Controller
{
    /**
     * Display lessons for a specific course
     */
    public function index(Course $course)
    {
        $course->load(['lessons' => function($query) {
            $query->ordered();
        }, 'category', 'scholar']);

        return view('admin.courses.lessons.index', compact('course'));
    }

    /**
     * Show the form for creating a new lesson
     */
    public function create(Course $course)
    {
        // الحصول على الترتيب التالي
        $nextOrder = $course->lessons()->max('lesson_order') + 1;

        return view('admin.courses.lessons.create', compact('course', 'nextOrder'));
    }

    /**
     * Store a newly created lesson
     */
    public function store(Request $request, Course $course)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video_duration' => 'nullable|string|max:20',
            'lesson_order' => 'required|integer|min:1',
            'resources' => 'nullable|array',
            'resources.*.title' => 'required_with:resources|string|max:255',
            'resources.*.url' => 'required_with:resources|url',
            'resources.*.type' => 'required_with:resources|in:pdf,link,video',
            'status' => 'required|boolean'
        ]);

        // تحضير موارد الدرس
        $resources = [];
        if ($request->has('resources') && is_array($request->resources)) {
            foreach ($request->resources as $resource) {
                if (!empty($resource['title']) && !empty($resource['url'])) {
                    $resources[] = [
                        'title' => $resource['title'],
                        'url' => $resource['url'],
                        'type' => $resource['type'] ?? 'link'
                    ];
                }
            }
        }
        $validated['resources'] = $resources;

        // إضافة معرف الدورة
        $validated['course_id'] = $course->id;

        // التحقق من عدم تكرار ترتيب الدرس
        if ($course->lessons()->where('lesson_order', $validated['lesson_order'])->exists()) {
            // إعادة ترقيم الدروس
            $course->lessons()
                   ->where('lesson_order', '>=', $validated['lesson_order'])
                   ->increment('lesson_order');
        }

        $lesson = CourseLesson::create($validated);

        return redirect()->route('admin.courses.lessons.index', $course)
                        ->with('success', 'تم إضافة الدرس بنجاح');
    }

    /**
     * Display the specified lesson
     */
    public function show(Course $course, CourseLesson $lesson)
    {
        $lesson->load('course.scholar');

        return view('admin.courses.lessons.show', compact('course', 'lesson'));
    }

    /**
     * Show the form for editing the specified lesson
     */
    public function edit(Course $course, CourseLesson $lesson)
    {
        return view('admin.courses.lessons.edit', compact('course', 'lesson'));
    }

    /**
     * Update the specified lesson
     */
    public function update(Request $request, Course $course, CourseLesson $lesson)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'video_url' => 'nullable|url',
            'video_duration' => 'nullable|string|max:20',
            'lesson_order' => 'required|integer|min:1',
            'resources' => 'nullable|array',
            'resources.*.title' => 'required_with:resources|string|max:255',
            'resources.*.url' => 'required_with:resources|url',
            'resources.*.type' => 'required_with:resources|in:pdf,link,video',
            'status' => 'required|boolean'
        ]);

        // تحضير موارد الدرس
        $resources = [];
        if ($request->has('resources') && is_array($request->resources)) {
            foreach ($request->resources as $resource) {
                if (!empty($resource['title']) && !empty($resource['url'])) {
                    $resources[] = [
                        'title' => $resource['title'],
                        'url' => $resource['url'],
                        'type' => $resource['type'] ?? 'link'
                    ];
                }
            }
        }
        $validated['resources'] = $resources;

        // التحقق من تغيير ترتيب الدرس
        if ($lesson->lesson_order != $validated['lesson_order']) {
            // التحقق من عدم تكرار ترتيب الدرس
            if ($course->lessons()
                       ->where('lesson_order', $validated['lesson_order'])
                       ->where('id', '!=', $lesson->id)
                       ->exists()) {
                
                $oldOrder = $lesson->lesson_order;
                $newOrder = $validated['lesson_order'];
                
                if ($newOrder > $oldOrder) {
                    // نقل للأسفل
                    $course->lessons()
                           ->where('lesson_order', '>', $oldOrder)
                           ->where('lesson_order', '<=', $newOrder)
                           ->where('id', '!=', $lesson->id)
                           ->decrement('lesson_order');
                } else {
                    // نقل للأعلى
                    $course->lessons()
                           ->where('lesson_order', '>=', $newOrder)
                           ->where('lesson_order', '<', $oldOrder)
                           ->where('id', '!=', $lesson->id)
                           ->increment('lesson_order');
                }
            }
        }

        $lesson->update($validated);

        return redirect()->route('admin.courses.lessons.index', $course)
                        ->with('success', 'تم تحديث الدرس بنجاح');
    }

    /**
     * Remove the specified lesson
     */
    public function destroy(Course $course, CourseLesson $lesson)
    {
        $lessonOrder = $lesson->lesson_order;

        $lesson->delete();

        // إعادة ترقيم الدروس التي تليه
        $course->lessons()
               ->where('lesson_order', '>', $lessonOrder)
               ->decrement('lesson_order');

        return redirect()->route('admin.courses.lessons.index', $course)
                        ->with('success', 'تم حذف الدرس بنجاح');
    }

    /**
     * Toggle lesson status
     */
    public function toggleStatus(Course $course, CourseLesson $lesson)
    {
        $lesson->update(['status' => !$lesson->status]);

        $message = $lesson->status ? 'تم تفعيل الدرس' : 'تم إلغاء تفعيل الدرس';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Reorder lessons via AJAX
     */
    public function reorder(Request $request, Course $course)
    {
        $validated = $request->validate([
            'lessons' => 'required|array',
            'lessons.*.id' => 'required|exists:course_lessons,id',
            'lessons.*.lesson_order' => 'required|integer|min:1'
        ]);

        foreach ($validated['lessons'] as $lessonData) {
            CourseLesson::where('id', $lessonData['id'])
                       ->where('course_id', $course->id)
                       ->update(['lesson_order' => $lessonData['lesson_order']]);
        }

        return response()->json([
            'success' => true, 
            'message' => 'تم تحديث ترتيب الدروس بنجاح'
        ]);
    }

    /**
     * Duplicate a lesson
     */
    public function duplicate(Course $course, CourseLesson $lesson)
    {
        $newLesson = $lesson->replicate();
        $newLesson->title = $lesson->title . ' (نسخة)';
        $newLesson->lesson_order = $course->lessons()->max('lesson_order') + 1;
        $newLesson->status = false; // الدرس المنسوخ يكون معطل بشكل افتراضي
        $newLesson->save();

        return redirect()->route('admin.courses.lessons.edit', [$course, $newLesson])
                        ->with('success', 'تم نسخ الدرس بنجاح، يمكنك الآن تعديله');
    }

    /**
     * Preview lesson for testing
     */
    public function preview(Course $course, CourseLesson $lesson)
    {
        $lesson->load('course.scholar');

        return view('admin.courses.lessons.preview', compact('course', 'lesson'));
    }
}
