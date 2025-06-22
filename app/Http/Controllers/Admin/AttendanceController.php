<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class AttendanceController extends Controller
{    public function index(Request $request)
    {
        $user = auth()->user();
        
        // بناء الاستعلام الأساسي
        $query = Attendance::with(['student', 'lesson.teacher']);
        
        // تطبيق فلاتر الصلاحيات
        if ($user->role === 'teacher') {
            $query->whereHas('lesson', function($q) use ($user) {
                $q->where('teacher_id', $user->id);
            });
        }
        
        // فلاتر البحث والتصفية
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->whereHas('student', function($sq) use ($search) {
                    $sq->where('name', 'like', "%{$search}%")
                       ->orWhere('email', 'like', "%{$search}%");
                })->orWhereHas('lesson', function($lq) use ($search) {
                    $lq->where('subject', 'like', "%{$search}%")
                       ->orWhere('name', 'like', "%{$search}%");
                });
            });
        }
        
        if ($request->filled('lesson_id')) {
            $query->where('lesson_id', $request->lesson_id);
        }
        
        if ($request->filled('status')) {
            $query->where('status', $request->status);
        }
        
        if ($request->filled('date_from')) {
            $query->where('date', '>=', $request->date_from);
        }
        
        if ($request->filled('date_to')) {
            $query->where('date', '<=', $request->date_to);
        }
        
        // ترتيب النتائج
        $attendances = $query->orderBy('date', 'desc')
                            ->orderBy('created_at', 'desc')
                            ->paginate(20);
        
        // جلب الدروس للفلاتر
        if ($user->role === 'admin') {
            $lessons = Lesson::with('teacher')->orderBy('subject')->get();
        } else {
            $lessons = Lesson::where('teacher_id', $user->id)->orderBy('subject')->get();
        }
        
        // حساب الإحصائيات السريعة
        $statsQuery = clone $query;
        $totalRecords = $statsQuery->count();
        $todayRecords = $statsQuery->whereDate('date', today())->count();
        
        $stats = [
            'total' => $totalRecords,
            'today' => $todayRecords,
            'present_today' => $statsQuery->whereDate('date', today())->where('status', 'present')->count(),
            'absent_today' => $statsQuery->whereDate('date', today())->where('status', 'absent')->count(),
        ];
        
        return view('admin.attendances.index', compact('attendances', 'lessons', 'stats'));
    }    public function create()
    {
        $user = auth()->user();
        
        // المدير لا يمكنه تسجيل الحضور
        if ($user->role === 'admin') {
            return redirect()->route('admin.attendances.index')
                ->with('error', 'المدير يمكنه عرض الحضور فقط، لا يمكن التسجيل');
        }
        
        $lessons = Lesson::where('teacher_id', $user->id)->get();
        
        return view('admin.attendances.create', compact('lessons'));
    }

    public function store(Request $request)
    {
        // المدير لا يمكنه تسجيل الحضور
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.attendances.index')
                ->with('error', 'المدير يمكنه عرض الحضور فقط، لا يمكن التسجيل');
        }

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

    /**
     * عرض تقارير الحضور
     */
    public function reports(Request $request)
    {
        $user = auth()->user();
        
        // جلب الدروس والطلاب للفلاتر
        if ($user->role === 'admin') {
            $lessons = Lesson::with('teacher')->get();
            $students = User::where('role', 'student')->get();
        } else {
            $lessons = Lesson::where('teacher_id', $user->id)->get();
            $students = User::where('role', 'student')
                ->whereHas('lessons', function($query) use ($user) {
                    $query->where('teacher_id', $user->id);
                })->get();
        }

        // بناء الاستعلام
        $query = Attendance::with(['student', 'lesson.teacher']);
        
        // تطبيق فلاتر المعلم
        if ($user->role === 'teacher') {
            $query->whereHas('lesson', function($q) use ($user) {
                $q->where('teacher_id', $user->id);
            });
        }

        // تطبيق الفلاتر المطلوبة
        if ($request->filled('lesson_id')) {
            $query->where('lesson_id', $request->lesson_id);
        }

        if ($request->filled('student_id')) {
            $query->where('student_id', $request->student_id);
        }

        if ($request->filled('start_date')) {
            $query->where('date', '>=', $request->start_date);
        }

        if ($request->filled('end_date')) {
            $query->where('date', '<=', $request->end_date);
        }

        // جلب النتائج
        $attendances = $query->orderBy('date', 'desc')->paginate(20);

        // حساب الإحصائيات
        $statisticsQuery = clone $query;
        $allAttendances = $statisticsQuery->get();
        
        $statistics = [
            'present' => $allAttendances->where('status', 'present')->count(),
            'absent' => $allAttendances->where('status', 'absent')->count(),
            'late' => $allAttendances->where('status', 'late')->count(),
            'excused' => $allAttendances->where('status', 'excused')->count(),
        ];

        return view('admin.attendances.reports', compact(
            'attendances', 'lessons', 'students', 'statistics'
        ));
    }

    public function show(Attendance $attendance)
    {
        $this->authorizeAttendance($attendance);
        
        $attendance->load(['student', 'lesson.teacher']);
        
        return view('admin.attendances.show', compact('attendance'));
    }

    public function edit(Attendance $attendance)
    {
        $this->authorizeAttendance($attendance);
        
        // المدير لا يمكنه تعديل الحضور
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.attendances.index')
                ->with('error', 'المدير يمكنه عرض الحضور فقط، لا يمكن التعديل');
        }
        
        $user = auth()->user();
        $lessons = Lesson::where('teacher_id', $user->id)->get();
        $students = User::where('role', 'student')->get();
        
        return view('admin.attendances.edit', compact('attendance', 'lessons', 'students'));
    }

    public function update(Request $request, Attendance $attendance)
    {
        $this->authorizeAttendance($attendance);
        
        // المدير لا يمكنه تعديل الحضور
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.attendances.index')
                ->with('error', 'المدير يمكنه عرض الحضور فقط، لا يمكن التعديل');
        }
        
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
        
        // المدير لا يمكنه حذف الحضور
        if (auth()->user()->role === 'admin') {
            return redirect()->route('admin.attendances.index')
                ->with('error', 'المدير يمكنه عرض الحضور فقط، لا يمكن الحذف');
        }
        
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
