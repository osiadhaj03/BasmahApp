<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{    public function index()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $attendances = Attendance::with(['student', 'lesson.teacher'])
                ->orderBy('date', 'desc')
                ->paginate(15);
        } else {
            $attendances = Attendance::with(['student', 'lesson'])
                ->whereHas('lesson', function($query) use ($user) {
                    $query->where('teacher_id', $user->id);
                })
                ->orderBy('date', 'desc')
                ->paginate(15);
        }
        
        return view('admin.attendances.index', compact('attendances'));
    }

    public function create()
    {
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $lessons = Lesson::with('teacher')->get();
        } else {
            $lessons = Lesson::where('teacher_id', $user->id)->get();
        }
        
        return view('admin.attendances.create', compact('lessons'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'student_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,excused',
        ]);

        $this->authorizeLesson($request->lesson_id);

        // التحقق من أن الطالب مسجل في هذا الدرس
        $lesson = Lesson::findOrFail($request->lesson_id);
        if (!$lesson->students()->where('student_id', $request->student_id)->exists()) {
            return back()->withErrors(['student_id' => 'الطالب غير مسجل في هذا الدرس']);
        }

        // التحقق من عدم وجود سجل حضور مسبق لنفس الطالب والدرس والتاريخ
        $existingAttendance = Attendance::where([
            'lesson_id' => $request->lesson_id,
            'student_id' => $request->student_id,
            'date' => $request->date,
        ])->first();

        if ($existingAttendance) {
            return back()->withErrors(['date' => 'سجل الحضور موجود مسبقاً لهذا التاريخ']);
        }

        Attendance::create($request->all());

        return redirect()->route('admin.attendances.index')
            ->with('success', 'تم تسجيل الحضور بنجاح');
    }

    public function show(Attendance $attendance)
    {
        $this->authorizeAttendance($attendance);
        
        $attendance->load(['student', 'lesson.teacher']);
        
        return view('admin.attendances.show', compact('attendance'));
    }    public function edit(Attendance $attendance)
    {
        $this->authorizeAttendance($attendance);
        
        $user = auth()->user();
        
        if ($user->role === 'admin') {
            $lessons = Lesson::with('teacher')->get();
        } else {
            $lessons = Lesson::where('teacher_id', $user->id)->get();
        }
        
        $students = User::where('role', 'student')->get();
        
        return view('admin.attendances.edit', compact('attendance', 'lessons', 'students'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $this->authorizeAttendance($attendance);
        
        $request->validate([
            'lesson_id' => 'required|exists:lessons,id',
            'student_id' => 'required|exists:users,id',
            'date' => 'required|date',
            'status' => 'required|in:present,absent,late,excused',
        ]);

        $this->authorizeLesson($request->lesson_id);

        $attendance->update($request->all());

        return redirect()->route('admin.attendances.index')
            ->with('success', 'تم تحديث الحضور بنجاح');
    }

    public function destroy(Attendance $attendance)
    {
        $this->authorizeAttendance($attendance);
        
        $attendance->delete();
        
        return redirect()->route('admin.attendances.index')
            ->with('success', 'تم حذف سجل الحضور بنجاح');
    }

    public function getStudents(Lesson $lesson)
    {
        $this->authorizeLesson($lesson->id);
        
        return response()->json([
            'students' => $lesson->students()->select('id', 'name')->get()
        ]);
    }

    private function authorizeLesson($lessonId)
    {
        $user = auth()->user();
        
        if ($user->role === 'teacher') {
            $lesson = Lesson::findOrFail($lessonId);
            if ($lesson->teacher_id !== $user->id) {
                abort(403, 'غير مسموح لك بالوصول لهذا الدرس');
            }
        }
    }

    private function authorizeAttendance(Attendance $attendance)
    {
        $user = auth()->user();
        
        if ($user->role === 'teacher' && $attendance->lesson->teacher_id !== $user->id) {
            abort(403, 'غير مسموح لك بالوصول لهذا السجل');
        }
    }
}
