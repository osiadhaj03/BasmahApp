<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Article extends Model
{
    use HasFactory;    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'category',
        'featured_image',
        'tags',
        'is_featured',
        'is_published',
        'views_count',
        'likes_count',
        'shares_count',
        'reading_time',
        'meta_title',
        'meta_description',
        'meta_keywords',
        'allow_comments',
        'references',
        'published_at',
    ];

    protected $casts = [
        'tags' => 'array',
        'references' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'reading_time' => 'decimal:2',
        'published_at' => 'datetime',
    ];

    // العلاقات
    public function author(): BelongsTo
    {
        return $this->belongsTo(User::class, 'author_id');
    }

    // النطاقات (Scopes)
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where('published_at', '<=', now());
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByCategory($query, $category)
    {
        return $query->where('category', $category);
    }

    public function scopeRecent($query, $limit = 5)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }

    // الوصفات (Accessors)
    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return asset('images/default-article-image.png');
    }

    public function getFormattedPublishedAtAttribute()
    {
        return $this->published_at ? $this->published_at->format('Y/m/d') : null;
    }

    // إنشاء الرابط الودود تلقائياً
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value, '-');
    }

    // حساب وقت القراءة التقديري
    public function calculateReadingTime()
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $readingTime = ceil($wordCount / 200); // افتراض 200 كلمة في الدقيقة
        $this->update(['reading_time' => $readingTime]);
        return $readingTime;
    }

    // زيادة عدد المشاهدات
    public function incrementViews()
    {
        $this->increment('views_count');
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
            'contemporary' => 'القضايا المعاصرة',
            'research' => 'البحوث العلمية',
            'general' => 'عام',
        ];
    }
}
