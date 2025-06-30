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
        
        // إذا كان المستخدم معلم، وجهه لصفحة المعلم
        if ($user->role === 'teacher') {
            return redirect()->route('teacher.dashboard');
        }
        
        // باقي الكود للمدير فقط
        if ($user->role === 'admin') {
            $data = [
                'totalUsers' => User::count(),
                'totalTeachers' => User::where('role', 'teacher')->count(),
                'totalStudents' => User::where('role', 'student')->count(),
                'totalLessons' => Lesson::count(),
                'totalAttendances' => Attendance::count(),
                'todayAttendances' => Attendance::whereDate('date', today())->count(),
                
                // Content Management Statistics
                'totalBooks' => \App\Models\Book::count(),
                'publishedBooks' => \App\Models\Book::where('is_published', true)->count(),
                'totalArticles' => \App\Models\Article::count(),
                'publishedArticles' => \App\Models\Article::where('is_published', true)->count(),
                'totalNews' => \App\Models\News::count(),
                'urgentNews' => \App\Models\News::where('priority', 'urgent')->count(),
            ];
            
            return view('admin.dashboard', compact('data', 'user'));
        }
        
        // إذا لم يكن المستخدم مدير أو معلم
        abort(403, 'غير مسموح لك بالوصول لهذه الصفحة');
    }
}
