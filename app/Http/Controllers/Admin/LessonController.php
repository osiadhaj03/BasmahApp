<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class LessonController extends Controller
{    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $lessons = Lesson::with(['teacher', 'students'])->paginate(10);
        } else {
            $lessons = Lesson::with(['teacher', 'students'])
                ->where('teacher_id', $user->id)
                ->paginate(10);
        }
        
        return view('admin.lessons.index', compact('lessons'));
    }

    public function create()
    {
        $teachers = User::where('role', 'teacher')->get();
        $students = User::where('role', 'student')->get();
        
        return view('admin.lessons.create', compact('teachers', 'students'));
    }    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'teacher_id' => 'required|exists:users,id',
            'day_of_week' => 'required|string|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'schedule_time' => 'nullable|date_format:H:i',
            'description' => 'nullable|string',
            'students' => 'array',
            'students.*' => 'exists:users,id',
        ]);

        $user = auth()->user();
        
        // إذا كان المستخدم معلم، يجب أن يكون هو المعلم المخصص للدرس
        if ($user->role === 'teacher') {
            $request->merge(['teacher_id' => $user->id]);
        }

        // إذا لم يتم تحديد schedule_time، استخدم start_time كافتراضي
        if (!$request->schedule_time) {
            $request->merge(['schedule_time' => $request->start_time]);
        }

        $lesson = Lesson::create($request->only([
            'name', 'subject', 'teacher_id', 'day_of_week', 'start_time', 'end_time', 'schedule_time', 'description'
        ]));

        if ($request->has('students')) {
            $lesson->students()->attach($request->students);
        }

        return redirect()->route('admin.lessons.index')
            ->with('success', 'تم إنشاء الدرس بنجاح');
    }

    public function show(Lesson $lesson)
    {
        $this->authorizeLesson($lesson);
        
        $lesson->load(['teacher', 'students', 'attendances.student']);
        
        return view('admin.lessons.show', compact('lesson'));
    }

    public function edit(Lesson $lesson)
    {
        $this->authorizeLesson($lesson);
        
        $teachers = User::where('role', 'teacher')->get();
        $students = User::where('role', 'student')->get();
        
        return view('admin.lessons.edit', compact('lesson', 'teachers', 'students'));
    }    public function update(Request $request, Lesson $lesson)
    {
        $this->authorizeLesson($lesson);
        
        $request->validate([
            'name' => 'required|string|max:255',
            'subject' => 'nullable|string|max:255',
            'teacher_id' => 'required|exists:users,id',
            'day_of_week' => 'required|string|in:sunday,monday,tuesday,wednesday,thursday,friday,saturday',
            'start_time' => 'required|date_format:H:i',
            'end_time' => 'required|date_format:H:i|after:start_time',
            'schedule_time' => 'nullable|date_format:H:i',
            'description' => 'nullable|string',
            'students' => 'array',
            'students.*' => 'exists:users,id',
        ]);

        $user = auth()->user();
        
        // إذا كان المستخدم معلم، يجب أن يبقى هو المعلم المخصص للدرس
        if ($user->role === 'teacher') {
            $request->merge(['teacher_id' => $user->id]);
        }

        // إذا لم يتم تحديد schedule_time، استخدم start_time كافتراضي
        if (!$request->schedule_time) {
            $request->merge(['schedule_time' => $request->start_time]);
        }

        $lesson->update($request->only([
            'name', 'subject', 'teacher_id', 'day_of_week', 'start_time', 'end_time', 'schedule_time', 'description'
        ]));

        if ($request->has('students')) {
            $lesson->students()->sync($request->students);
        } else {
            $lesson->students()->detach();
        }        return redirect()->route('admin.lessons.index')
            ->with('success', 'تم تحديث الدرس بنجاح');
    }

    public function destroy(Lesson $lesson)
    {
        $this->authorizeLesson($lesson);
        
        $lesson->delete();
        
        return redirect()->route('admin.lessons.index')
            ->with('success', 'تم حذف الدرس بنجاح');
    }

    private function authorizeLesson(Lesson $lesson)
    {
        $user = auth()->user();
        
        if ($user->role === 'teacher' && $lesson->teacher_id !== $user->id) {
            abort(403, 'غير مسموح لك بالوصول لهذا الدرس');
        }
    }
}
