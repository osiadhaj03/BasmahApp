<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseLesson extends Model
{
    use HasFactory;

    protected $fillable = [
        'course_id',
        'title',
        'description',
        'video_url',
        'video_duration',
        'lesson_order',
        'resources',
        'status'
    ];

    protected $casts = [
        'resources' => 'array',
        'status' => 'boolean'
    ];

    /**
     * Get the course that owns the lesson
     */
    public function course()
    {
        return $this->belongsTo(Course::class);
    }

    /**
     * Get the previous lesson in the course
     */
    public function getPreviousLessonAttribute()
    {
        return $this->course->lessons()
                    ->where('lesson_order', '<', $this->lesson_order)
                    ->where('status', true)
                    ->orderBy('lesson_order', 'desc')
                    ->first();
    }

    /**
     * Get the next lesson in the course
     */
    public function getNextLessonAttribute()
    {
        return $this->course->lessons()
                    ->where('lesson_order', '>', $this->lesson_order)
                    ->where('status', true)
                    ->orderBy('lesson_order', 'asc')
                    ->first();
    }

    /**
     * Get YouTube video embed URL
     */
    public function getVideoEmbedUrlAttribute()
    {
        if (!$this->video_url) {
            return null;
        }

        // Extract YouTube video ID from various YouTube URL formats
        $pattern = '/(?:youtube\.com\/(?:[^\/]+\/.+\/|(?:v|e(?:mbed)?)\/|.*[?&]v=)|youtu\.be\/)([^"&?\/\s]{11})/';
        if (preg_match($pattern, $this->video_url, $matches)) {
            return "https://www.youtube.com/embed/{$matches[1]}?rel=0";
        }

        return $this->video_url;
    }

    /**
     * Get formatted video duration
     */
    public function getFormattedDurationAttribute()
    {
        if (!$this->video_duration) {
            return null;
        }

        // If duration is in seconds, convert to mm:ss format
        if (is_numeric($this->video_duration)) {
            $minutes = floor($this->video_duration / 60);
            $seconds = $this->video_duration % 60;
            return sprintf('%02d:%02d', $minutes, $seconds);
        }

        return $this->video_duration;
    }

    /**
     * Check if lesson has resources
     */
    public function getHasResourcesAttribute()
    {
        return !empty($this->resources) && is_array($this->resources);
    }

    /**
     * Scope for active lessons
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope for ordered lessons
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('lesson_order');
    }

    /**
     * Scope for lessons in a specific course
     */
    public function scopeInCourse($query, $courseId)
    {
        return $query->where('course_id', $courseId);
    }
}
