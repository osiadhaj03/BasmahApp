<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Scholar extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'biography',
        'specialization',
        'photo',
        'birth_date',
        'death_date',
        'status'
    ];

    protected $casts = [
        'birth_date' => 'date',
        'death_date' => 'date',
        'status' => 'boolean'
    ];

    /**
     * Get all courses for this scholar
     */
    public function courses()
    {
        return $this->hasMany(Course::class);
    }

    /**
     * Get active courses for this scholar
     */
    public function activeCourses()
    {
        return $this->hasMany(Course::class)->where('status', true);
    }

    /**
     * Get the photo URL with fallback
     */
    public function getPhotoUrlAttribute()
    {
        if ($this->photo) {
            return asset('storage/' . $this->photo);
        }
        return asset('images/default-scholar.png');
    }

    /**
     * Get formatted birth-death date
     */
    public function getLifespanAttribute()
    {
        $birth = $this->birth_date ? $this->birth_date->format('Y') : '?';
        $death = $this->death_date ? $this->death_date->format('Y') : 'الحاضر';
        return $birth . ' - ' . $death;
    }

    /**
     * Scope for active scholars
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
