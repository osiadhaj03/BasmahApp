<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Attendance;
use App\Models\Lesson;
use App\Models\User;
use Illuminate\Http\Request;

class AdminController extends Controller
{    public function dashboard()
    {
        $user = auth()->user();
        $data = [];
        
        if ($user->role === 'admin') {
            $data = [
                'totalUsers' => User::count(),
                'totalTeachers' => User::where('role', 'teacher')->count(),
                'totalStudents' => User::where('role', 'student')->count(),
                'totalLessons' => Lesson::count(),
                'totalAttendances' => Attendance::count(),
                'todayAttendances' => Attendance::whereDate('date', today())->count(),
            ];
        } elseif ($user->role === 'teacher') {
            $teacherLessons = Lesson::where('teacher_id', $user->id)->pluck('id');
            $data = [
                'myLessons' => $teacherLessons->count(),
                'myStudents' => Lesson::where('teacher_id', $user->id)
                    ->withCount('students')
                    ->get()
                    ->sum('students_count'),
                'todayAttendances' => Attendance::whereIn('lesson_id', $teacherLessons)
                    ->whereDate('date', today())
                    ->count(),
                'totalAttendances' => Attendance::whereIn('lesson_id', $teacherLessons)->count(),
            ];
        }
        
        return view('admin.dashboard', compact('data', 'user'));
    }
}
