<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Book extends Model
{
    use HasFactory;    protected $fillable = [
        'title',
        'author',
        'description',
        'category',
        'cover_image',
        'file_path',
        'download_url',
        'pages',
        'language',
        'is_featured',
        'is_published',
        'download_count',
        'rating',
        'tags',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'rating' => 'decimal:2',
    ];

    // العلاقات
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // النطاقات (Scopes)
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    // الوصفات (Accessors)
    public function getFileUrlAttribute()
    {
        if ($this->file_path) {
            return asset('storage/' . $this->file_path);
        }
        return $this->download_url;
    }

    public function getCoverImageUrlAttribute()
    {
        if ($this->cover_image) {
            return asset('storage/' . $this->cover_image);
        }
        return asset('images/default-book-cover.png');
    }

    // التصنيفات المتاحة
    public static function getCategories()
    {
        return [
            'fiqh' => 'الفقه',
            'aqeedah' => 'العقيدة',
            'hadith' => 'الحديث',
            'tafseer' => 'التفسير',
            'seerah' => 'السيرة النبوية',
            'ethics' => 'الأخلاق والآداب',
            'dua' => 'الدعاء والأذكار',
            'history' => 'التاريخ الإسلامي',
            'language' => 'اللغة العربية',
            'general' => 'عام',
        ];
    }

    // زيادة عدد التحميلات
    public function incrementDownloadCount()
    {
        $this->increment('download_count');
    }
}
