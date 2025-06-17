<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Attendance;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Carbon\Carbon;

class QRCodeController extends Controller
{
    /**
     * Generate QR code for a lesson (Teacher view)
     */
    public function generateLessonQR(Request $request, Lesson $lesson)
    {
        // التأكد من أن المستخدم معلم أو مدير ولديه صلاحية
        $user = auth()->user();
        if (!$user || (!$user->isAdmin() && $lesson->teacher_id !== $user->id)) {
            abort(403, 'غير مسموح لك بالوصول لهذا الدرس');
        }

        // توليد QR Code جديد
        $qrData = $lesson->generateQRCode();
        
        // إنشاء QR Code كصورة
        $qrCode = QrCode::format('png')
            ->size(300)
            ->errorCorrection('H')
            ->generate($qrData);

        return view('admin.lessons.qr-display', compact('lesson', 'qrCode'));
    }

    /**
     * Display QR code for classroom projection
     */
    public function displayQR(Lesson $lesson)
    {
        $user = auth()->user();
        if (!$user || (!$user->isAdmin() && $lesson->teacher_id !== $user->id)) {
            abort(403, 'غير مسموح لك بالوصول لهذا الدرس');
        }

        // التأكد من وجود QR Code صالح
        if (!$lesson->isQRCodeValid()) {
            $lesson->generateQRCode();
        }

        $qrCode = QrCode::format('svg')
            ->size(400)
            ->errorCorrection('H')
            ->generate($lesson->qr_code);

        return view('admin.lessons.qr-fullscreen', compact('lesson', 'qrCode'));
    }

    /**
     * Process QR code scan for attendance (Student)
     */
    public function scanQR(Request $request)
    {
        $request->validate([
            'qr_data' => 'required|string'
        ]);

        $user = auth()->user();
        if (!$user || !$user->isStudent()) {
            return response()->json([
                'success' => false,
                'message' => 'يجب أن تكون طالب لتسجيل الحضور'
            ], 403);
        }

        // التحقق من صحة QR Code
        $lesson = Lesson::verifyQRCode($request->qr_data);
        if (!$lesson) {
            return response()->json([
                'success' => false,
                'message' => 'QR Code غير صالح أو منتهي الصلاحية'
            ], 400);
        }

        // التحقق من أن الطالب مسجل في هذا الدرس
        if (!$lesson->students()->where('student_id', $user->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'أنت غير مسجل في هذا الدرس'
            ], 403);
        }

        // التحقق من نافذة الحضور (أول 15 دقيقة)
        if (!$lesson->isWithinAttendanceWindow()) {
            return response()->json([
                'success' => false,
                'message' => 'انتهت فترة تسجيل الحضور (أول 15 دقيقة من بداية الدرس)'
            ], 400);
        }

        // التحقق من عدم وجود حضور مسبق لنفس اليوم
        $today = now()->format('Y-m-d');
        $existingAttendance = Attendance::where('student_id', $user->id)
            ->where('lesson_id', $lesson->id)
            ->where('date', $today)
            ->first();

        if ($existingAttendance) {
            return response()->json([
                'success' => false,
                'message' => 'تم تسجيل حضورك مسبقاً في هذا الدرس اليوم'
            ], 400);
        }

        // تسجيل الحضور
        $attendance = Attendance::create([
            'student_id' => $user->id,
            'lesson_id' => $lesson->id,
            'date' => $today,
            'status' => 'present',
            'notes' => 'تم التسجيل عبر QR Code في ' . now()->format('H:i:s')
        ]);

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل حضورك بنجاح في درس ' . $lesson->name,
            'attendance_id' => $attendance->id,
            'lesson_name' => $lesson->name,
            'time' => now()->format('H:i')
        ]);
    }

    /**
     * Get QR scanner page for students
     */
    public function scanner()
    {
        $user = auth()->user();
        if (!$user || !$user->isStudent()) {
            abort(403, 'هذه الصفحة مخصصة للطلاب فقط');
        }

        return view('student.qr-scanner');
    }

    /**
     * Get lesson QR info for API
     */
    public function getLessonQRInfo(Lesson $lesson)
    {
        $user = auth()->user();
        if (!$user || (!$user->isAdmin() && $lesson->teacher_id !== $user->id)) {
            abort(403);
        }

        return response()->json([
            'lesson_id' => $lesson->id,
            'lesson_name' => $lesson->name,
            'subject' => $lesson->subject,
            'day' => $lesson->day_of_week,
            'start_time' => $lesson->start_time->format('H:i'),
            'end_time' => $lesson->end_time->format('H:i'),
            'qr_valid' => $lesson->isQRCodeValid(),
            'within_window' => $lesson->isWithinAttendanceWindow(),
            'students_count' => $lesson->students()->count()
        ]);
    }
}
