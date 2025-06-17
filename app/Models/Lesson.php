<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Carbon\Carbon;
use Illuminate\Support\Str;

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
        'schedule_time',
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
}
