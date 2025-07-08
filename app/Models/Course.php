<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Course extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'description',
        'category_id',
        'scholar_id',
        'thumbnail',
        'duration',
        'level',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    /**
     * Get the category that owns the course
     */
    public function category()
    {
        return $this->belongsTo(CourseCategory::class, 'category_id');
    }

    /**
     * Get the scholar that owns the course
     */
    public function scholar()
    {
        return $this->belongsTo(Scholar::class);
    }

    /**
     * Get all lessons for this course
     */
    public function lessons()
    {
        return $this->hasMany(CourseLesson::class)->orderBy('lesson_order');
    }

    /**
     * Get active lessons for this course
     */
    public function activeLessons()
    {
        return $this->hasMany(CourseLesson::class)->where('status', true)->orderBy('lesson_order');
    }

    /**
     * Get the thumbnail URL with fallback
     */
    public function getThumbnailUrlAttribute()
    {
        if ($this->thumbnail) {
            return asset('storage/' . $this->thumbnail);
        }
        return asset('images/default-course.png');
    }

    /**
     * Get lessons count for this course
     */
    public function getLessonsCountAttribute()
    {
        return $this->lessons()->count();
    }

    /**
     * Get active lessons count for this course
     */
    public function getActiveLessonsCountAttribute()
    {
        return $this->activeLessons()->count();
    }

    /**
     * Get level in Arabic
     */
    public function getLevelArabicAttribute()
    {
        $levels = [
            'beginner' => 'مبتدئ',
            'intermediate' => 'متوسط',
            'advanced' => 'متقدم'
        ];

        return $levels[$this->level] ?? 'مبتدئ';
    }

    /**
     * Scope for active courses
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope for ordered courses
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('created_at', 'desc');
    }

    /**
     * Scope for search
     */
    public function scopeSearch($query, $search)
    {
        if ($search) {
            return $query->where('title', 'LIKE', "%{$search}%")
                        ->orWhere('description', 'LIKE', "%{$search}%");
        }
        return $query;
    }

    /**
     * Scope for filtering by category
     */
    public function scopeByCategory($query, $categoryId)
    {
        if ($categoryId) {
            return $query->where('category_id', $categoryId);
        }
        return $query;
    }

    /**
     * Scope for filtering by scholar
     */
    public function scopeByScholar($query, $scholarId)
    {
        if ($scholarId) {
            return $query->where('scholar_id', $scholarId);
        }
        return $query;
    }

    /**
     * Scope for filtering by level
     */
    public function scopeByLevel($query, $level)
    {
        if ($level) {
            return $query->where('level', $level);
        }
        return $query;
    }
}
