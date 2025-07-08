<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CourseCategory extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'description',
        'icon',
        'color',
        'sort_order',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    /**
     * Get all courses in this category
     */
    public function courses()
    {
        return $this->hasMany(Course::class, 'category_id');
    }

    /**
     * Get active courses in this category
     */
    public function activeCourses()
    {
        return $this->hasMany(Course::class, 'category_id')->where('status', true);
    }

    /**
     * Get courses count for this category
     */
    public function getCoursesCountAttribute()
    {
        return $this->courses()->count();
    }

    /**
     * Get active courses count for this category
     */
    public function getActiveCoursesCountAttribute()
    {
        return $this->activeCourses()->count();
    }

    /**
     * Scope for active categories
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    /**
     * Scope for ordered categories
     */
    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order')->orderBy('name');
    }
}
