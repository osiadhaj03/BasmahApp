<?php

namespace App\Http\Controllers;

use App\Models\Lesson;
use App\Models\Attendance;
use App\Models\QrToken;
use Illuminate\Http\Request;
use SimpleSoftwareIO\QrCode\Facades\QrCode;
use Illuminate\Support\Facades\Crypt;
use Carbon\Carbon;

class QrCodeController extends Controller
{
    /**
     * Generate QR code image for a lesson token
     */
    public function generateQR(Request $request, $lessonId)
    {
        $lesson = Lesson::findOrFail($lessonId);
        
        // التأكد من أن المستخدم معلم أو مدير ولديه صلاحية
        $user = auth()->user();
        if (!$user || (!$user->isAdmin() && $lesson->teacher_id !== $user->id)) {
            abort(403, 'غير مسموح لك بالوصول لهذا الدرس');
        }

        // الحصول على token صالح أو إنشاء جديد
        $qrToken = $lesson->getValidQRToken();
        if (!$qrToken) {
            $qrToken = $lesson->generateQRCodeToken();
        }

        // إنشاء QR Code يحتوي على رابط لمسح Token
        $scanUrl = url("/attendance/scan?token=" . urlencode($qrToken->token));
        
        $qrCode = QrCode::format('png')
            ->size(300)
            ->errorCorrection('H')
            ->generate($scanUrl);

        return response($qrCode)
            ->header('Content-Type', 'image/png')
            ->header('Cache-Control', 'no-cache, no-store, must-revalidate')
            ->header('Pragma', 'no-cache')
            ->header('Expires', '0');
    }

    /**
     * Display QR code page for classroom projection
     */
    public function displayQR(Lesson $lesson)
    {
        $user = auth()->user();
        if (!$user || (!$user->isAdmin() && $lesson->teacher_id !== $user->id)) {
            abort(403, 'غير مسموح لك بالوصول لهذا الدرس');
        }

        return view('admin.lessons.qr-display', compact('lesson'));
    }

    /**
     * Process attendance scan using token
     */
    public function scanAttendance(Request $request)
    {
        $request->validate([
            'token' => 'required|string'
        ]);

        $user = auth()->user();
        if (!$user || !$user->isStudent()) {
            return response()->json([
                'success' => false,
                'message' => 'يجب أن تكون طالب لتسجيل الحضور'
            ], 403);
        }

        // البحث عن Token في قاعدة البيانات
        $qrToken = QrToken::where('token', $request->token)->first();
        
        if (!$qrToken) {
            return response()->json([
                'success' => false,
                'message' => 'رمز QR غير صحيح'
            ], 400);
        }

        // التحقق من صلاحية Token
        if (!$qrToken->isValid()) {
            return response()->json([
                'success' => false,
                'message' => $qrToken->isExpired() ? 'انتهت صلاحية رمز QR (15 دقيقة)' : 'تم استخدام رمز QR مسبقاً'
            ], 400);
        }

        $lesson = $qrToken->lesson;

        // التحقق من أن الطالب مسجل في هذا الدرس
        if (!$lesson->students()->where('student_id', $user->id)->exists()) {
            return response()->json([
                'success' => false,
                'message' => 'أنت غير مسجل في هذا الدرس'
            ], 403);
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

        // تحديد Token كمستخدم
        $qrToken->markAsUsed();

        return response()->json([
            'success' => true,
            'message' => 'تم تسجيل حضورك بنجاح في درس ' . $lesson->name,
            'attendance_id' => $attendance->id,
            'lesson_name' => $lesson->name,
            'subject' => $lesson->subject,
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
     * Get QR token info for API (for real-time updates)
     */
    public function getTokenInfo(Lesson $lesson)
    {
        $user = auth()->user();
        if (!$user || (!$user->isAdmin() && $lesson->teacher_id !== $user->id)) {
            abort(403);
        }

        $validToken = $lesson->getValidQRToken();
        
        return response()->json([
            'lesson_id' => $lesson->id,
            'lesson_name' => $lesson->name,
            'subject' => $lesson->subject,
            'has_valid_token' => !is_null($validToken),
            'token_expires_at' => $validToken ? $validToken->expires_at->format('Y-m-d H:i:s') : null,
            'token_remaining_minutes' => $validToken ? $validToken->expires_at->diffInMinutes(now()) : 0,
            'students_count' => $lesson->students()->count(),
            'qr_url' => $validToken ? route('qr.generate', $lesson->id) : null
        ]);
    }

    /**
     * Refresh QR token (generate new one)
     */
    public function refreshToken(Lesson $lesson)
    {
        $user = auth()->user();
        if (!$user || (!$user->isAdmin() && $lesson->teacher_id !== $user->id)) {
            abort(403);
        }

        $newToken = $lesson->generateQRCodeToken();
        
        return response()->json([
            'success' => true,
            'message' => 'تم توليد رمز QR جديد',
            'token_expires_at' => $newToken->expires_at->format('Y-m-d H:i:s'),
            'token_remaining_minutes' => 15
        ]);
    }
}
