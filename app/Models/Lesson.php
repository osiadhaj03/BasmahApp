<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Crypt;

class Lesson extends Model
{
    use HasFactory;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */    protected $fillable = [
        'name',
        'subject',
        'teacher_id',
        'day_of_week',
        'start_time',
        'end_time',
        'description',
        'status',
        'qr_code',
        'qr_generated_at',
    ];

    /**
     * The attributes that should be cast.
     *
     * @return array<string, string>
     */    protected function casts(): array
    {
        return [
            'start_time' => 'datetime:H:i',
            'end_time' => 'datetime:H:i',
            'qr_generated_at' => 'datetime',
        ];
    }

    /**
     * Get the teacher for this lesson
     */
    public function teacher(): BelongsTo
    {
        return $this->belongsTo(User::class, 'teacher_id');
    }

    /**
     * Get all students enrolled in this lesson
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'lesson_student', 'lesson_id', 'student_id')
                    ->withTimestamps();
    }

    /**
     * Get all attendances for this lesson
     */
    public function attendances(): HasMany
    {
        return $this->hasMany(Attendance::class);
    }

    /**
     * Get all QR tokens for this lesson
     */
    public function qrTokens(): HasMany
    {
        return $this->hasMany(QrToken::class);
    }

    /**
     * Get attendances for a specific date
     */
    public function attendancesForDate($date): HasMany
    {
        return $this->hasMany(Attendance::class)->where('date', $date);
    }

    /**
     * Scope to filter lessons by day of week
     */
    public function scopeForDay($query, $dayOfWeek)
    {
        return $query->where('day_of_week', $dayOfWeek);
    }    /**
     * Scope to filter lessons by teacher
     */
    public function scopeForTeacher($query, $teacherId)
    {
        return $query->where('teacher_id', $teacherId);
    }

    /**
     * Generate QR code for this lesson
     */
    public function generateQRCode()
    {
        $qrData = [
            'lesson_id' => $this->id,
            'date' => now()->format('Y-m-d'),
            'time' => now()->format('H:i:s'),
            'token' => Str::random(32)
        ];
        
        $this->qr_code = encrypt(json_encode($qrData));
        $this->qr_generated_at = now();
        $this->save();
        
        return $this->qr_code;
    }

    /**
     * Generate new QR token for this lesson (15 minutes validity)
     */
    public function generateQRCodeToken()
    {
        // حذف جميع التوكن المنتهية الصلاحية أو المستخدمة لهذا الدرس
        $this->qrTokens()->where(function($query) {
            $query->where('expires_at', '<', now())
                  ->orWhereNotNull('used_at');
        })->delete();

        // توليد token جديد
        $tokenData = [
            'lesson_id' => $this->id,
            'timestamp' => now()->timestamp,
            'random' => Str::random(16)
        ];
        
        $encryptedToken = base64_encode(Crypt::encrypt(json_encode($tokenData)));
        
        // إنشاء QR token في قاعدة البيانات
        $qrToken = $this->qrTokens()->create([
            'token' => $encryptedToken,
            'generated_at' => now(),
            'expires_at' => now()->addMinutes(15),
        ]);

        return $qrToken;
    }

    /**
     * Get valid QR token for this lesson
     */
    public function getValidQRToken()
    {
        return $this->qrTokens()
                    ->where('expires_at', '>', now())
                    ->whereNull('used_at')
                    ->latest('generated_at')
                    ->first();
    }

    /**
     * Check if QR code is valid for attendance
     */
    public function isQRCodeValid()
    {
        if (!$this->qr_code || !$this->qr_generated_at) {
            return false;
        }

        // QR Code صالح لمدة 6 ساعات فقط
        return $this->qr_generated_at->diffInHours(now()) <= 6;
    }

    /**
     * Check if current time is within attendance window (first 15 minutes)
     */
    public function isWithinAttendanceWindow()
    {
        $now = now();
        $currentDay = strtolower($now->format('l'));
        
        // تحويل أيام الأسبوع للعربية
        $dayMapping = [
            'sunday' => 'sunday',
            'monday' => 'monday', 
            'tuesday' => 'tuesday',
            'wednesday' => 'wednesday',
            'thursday' => 'thursday',
            'friday' => 'friday',
            'saturday' => 'saturday'
        ];

        // التحقق من أن اليوم الحالي يطابق يوم الدرس
        if ($this->day_of_week !== $currentDay) {
            return false;
        }

        // الحصول على وقت بداية الدرس اليوم
        $lessonStart = Carbon::createFromFormat('H:i', $this->start_time->format('H:i'));
        $lessonStart->setDate($now->year, $now->month, $now->day);
        
        // نافذة الحضور: 15 دقيقة من بداية الدرس
        $attendanceWindowEnd = $lessonStart->copy()->addMinutes(15);
        
        return $now->between($lessonStart, $attendanceWindowEnd);
    }

    /**
     * Check if QR generation is allowed (only during lesson time or 15 minutes before)
     */
    public function canGenerateQR()
    {
        // التحقق من وجود معلومات الدرس المطلوبة
        if (!$this->day_of_week || !$this->start_time || !$this->end_time) {
            return false;
        }

        $now = now();
        $currentDay = strtolower($now->format('l'));
        
        // التحقق من أن اليوم الحالي يطابق يوم الدرس
        if ($this->day_of_week !== $currentDay) {
            return false;
        }

        // الحصول على وقت بداية ونهاية الدرس اليوم
        $lessonStart = Carbon::createFromFormat('H:i', $this->start_time->format('H:i'));
        $lessonStart->setDate($now->year, $now->month, $now->day);
        
        $lessonEnd = Carbon::createFromFormat('H:i', $this->end_time->format('H:i'));
        $lessonEnd->setDate($now->year, $now->month, $now->day);
        
        // السماح بتوليد QR قبل 15 دقيقة من بداية الدرس وحتى نهاية الدرس
        $qrGenerationStart = $lessonStart->copy()->subMinutes(15);
        
        return $now->between($qrGenerationStart, $lessonEnd);
    }

    /**
     * Get remaining time until QR generation is allowed
     */
    public function getTimeUntilQRGeneration()
    {
        if (!$this->day_of_week || !$this->start_time) {
            return null;
        }

        $now = now();
        $currentDay = strtolower($now->format('l'));
        
        // إذا لم يكن اليوم الصحيح، احسب الوقت للدرس القادم
        if ($this->day_of_week !== $currentDay) {
            // حساب عدد الأيام حتى الدرس القادم
            $daysOfWeek = [
                'sunday' => 0, 'monday' => 1, 'tuesday' => 2, 'wednesday' => 3,
                'thursday' => 4, 'friday' => 5, 'saturday' => 6
            ];
            
            $currentDayNumber = $daysOfWeek[$currentDay];
            $lessonDayNumber = $daysOfWeek[$this->day_of_week];
            
            $daysUntilLesson = ($lessonDayNumber - $currentDayNumber + 7) % 7;
            if ($daysUntilLesson === 0) {
                $daysUntilLesson = 7; // الأسبوع القادم
            }
            
            return $now->addDays($daysUntilLesson)->startOfDay()
                      ->addHours($this->start_time->hour)
                      ->addMinutes($this->start_time->minute)
                      ->subMinutes(15);
        }
        
        // نفس اليوم - احسب الوقت حتى 15 دقيقة قبل بداية الدرس
        $lessonStart = Carbon::createFromFormat('H:i', $this->start_time->format('H:i'));
        $lessonStart->setDate($now->year, $now->month, $now->day);
        $qrGenerationStart = $lessonStart->copy()->subMinutes(15);
        
        if ($now->isAfter($qrGenerationStart)) {
            return null; // الوقت مناسب الآن أو مضى
        }
        
        return $qrGenerationStart;
    }

    /**
     * Verify QR code data
     */
    public static function verifyQRCode($qrCode)
    {
        try {
            $data = json_decode(decrypt($qrCode), true);
            
            if (!isset($data['lesson_id']) || !isset($data['date']) || !isset($data['token'])) {
                return null;
            }
            
            $lesson = self::find($data['lesson_id']);
            
            if (!$lesson || !$lesson->isQRCodeValid()) {
                return null;
            }
            
            return $lesson;
            
        } catch (\Exception $e) {
            return null;
        }
    }

    /**
     * Get all available lesson statuses
     */
    public static function getStatuses()
    {
        return [
            'scheduled' => 'مجدول',
            'active' => 'نشط',
            'completed' => 'مكتمل',
            'cancelled' => 'ملغي'
        ];
    }

    /**
     * Get lesson status in Arabic
     */
    public function getStatusInArabic()
    {
        $statuses = self::getStatuses();
        return $statuses[$this->status] ?? 'غير محدد';
    }

    /**
     * Check if lesson is active
     */
    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Check if lesson is completed
     */
    public function isCompleted()
    {
        return $this->status === 'completed';
    }

    /**
     * Check if lesson is cancelled
     */
    public function isCancelled()
    {
        return $this->status === 'cancelled';
    }

    /**
     * Get the QR token associated with the lesson
     */
    public function qrToken(): BelongsTo
    {
        return $this->belongsTo(QrToken::class, 'id', 'lesson_id');
    }

    /**
     * Generate a dynamic token for the lesson
     */
    public function generateToken()
    {
        $token = Str::random(32);
        
        // تأكد من أن الرمز فريد وليس له علاقة قائمة بالفعل
        while (QrToken::where('token', $token)->exists()) {
            $token = Str::random(32);
        }
        
        return $token;
    }
}
