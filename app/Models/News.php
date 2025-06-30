<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class News extends Model
{
    use HasFactory;    protected $fillable = [
        'title',
        'slug',
        'summary',
        'content',
        'type',
        'priority',
        'featured_image',
        'images',
        'attachments',
        'tags',
        'is_featured',
        'is_published',
        'is_urgent',
        'send_notification',
        'allow_comments',
        'views_count',
        'source',
        'location',
        'external_link',
        'starts_at',
        'expires_at',
        'published_at',
    ];    protected $casts = [
        'images' => 'array',
        'attachments' => 'array',
        'tags' => 'array',
        'is_featured' => 'boolean',
        'is_published' => 'boolean',
        'is_urgent' => 'boolean',
        'send_notification' => 'boolean',
        'allow_comments' => 'boolean',
        'starts_at' => 'datetime',
        'expires_at' => 'datetime',
        'published_at' => 'datetime',
    ];

    // العلاقات
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    // النطاقات (Scopes)
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                    ->where('published_at', '<=', now())
                    ->where(function($q) {
                        $q->whereNull('expires_at')
                          ->orWhere('expires_at', '>', now());
                    });
    }

    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    public function scopeByType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeByPriority($query, $priority)
    {
        return $query->where('priority', $priority);
    }

    public function scopeUrgent($query)
    {
        return $query->where('priority', 'urgent');
    }

    public function scopeRecent($query, $limit = 5)
    {
        return $query->orderBy('published_at', 'desc')->limit($limit);
    }

    public function scopeActive($query)
    {
        return $query->where(function($q) {
            $q->whereNull('expires_at')
              ->orWhere('expires_at', '>', now());
        });
    }

    // الوصفات (Accessors)
    public function getFeaturedImageUrlAttribute()
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return asset('images/default-news-image.png');
    }

    public function getFormattedPublishedAtAttribute()
    {
        return $this->published_at ? $this->published_at->format('Y/m/d H:i') : null;
    }

    public function getIsExpiredAttribute()
    {
        return $this->expires_at && $this->expires_at->isPast();
    }

    public function getIsUrgentAttribute()
    {
        return $this->priority === 'urgent';
    }

    public function getDaysUntilExpiryAttribute()
    {
        if (!$this->expires_at) return null;
        return $this->expires_at->diffInDays(now(), false);
    }

    // إنشاء الرابط الودود تلقائياً
    public function setTitleAttribute($value)
    {
        $this->attributes['title'] = $value;
        $this->attributes['slug'] = Str::slug($value, '-');
    }

    // زيادة عدد المشاهدات
    public function incrementViews()
    {
        $this->increment('views_count');
    }

    // أنواع الأخبار المتاحة
    public static function getTypes()
    {
        return [
            'general' => 'خبر عام',
            'announcement' => 'إعلان',
            'event' => 'فعالية',
            'update' => 'تحديث',
            'course' => 'دورة تدريبية',
            'lecture' => 'محاضرة',
            'workshop' => 'ورشة عمل',
            'competition' => 'مسابقة',
            'achievement' => 'إنجاز',
            'other' => 'أخرى',
        ];
    }

    // مستويات الأولوية
    public static function getPriorities()
    {
        return [
            'urgent' => 'عاجل',
            'high' => 'مرتفع',
            'normal' => 'عادي',
            'low' => 'منخفض',
        ];
    }

    // ألوان الأولوية للواجهة
    public static function getPriorityColors()
    {
        return [
            'urgent' => 'danger',
            'high' => 'warning',
            'normal' => 'primary',
            'low' => 'secondary',
        ];
    }

    public function getPriorityColorAttribute()
    {
        return self::getPriorityColors()[$this->priority] ?? 'primary';
    }
}
