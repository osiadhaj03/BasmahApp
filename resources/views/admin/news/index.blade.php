@extends('layouts.admin')

@section('title', 'إدارة الأخبار والإعلانات')

@push('styles')
<style>
    .news-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        height: 100%;
    }
    .news-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .news-card.urgent {
        border: 2px solid #dc3545;
        animation: urgent-pulse 2s infinite;
    }
    @keyframes urgent-pulse {
        0% { box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3); }
        50% { box-shadow: 0 8px 25px rgba(220, 53, 69, 0.6); }
        100% { box-shadow: 0 4px 15px rgba(220, 53, 69, 0.3); }
    }
    .news-image {
        width: 100%;
        height: 160px;
        object-fit: cover;
        background: linear-gradient(135deg, var(--islamic-teal), var(--islamic-gold));
    }
    .news-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 10px;
        font-size: 0.85rem;
        color: #6c757d;
    }
    .meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .priority-badge {
        font-size: 0.75rem;
        padding: 3px 8px;
        border-radius: 12px;
        font-weight: 600;
    }
    .priority-urgent {
        background: #dc3545;
        color: white;
        animation: blink 1s infinite;
    }
    .priority-high {
        background: #fd7e14;
        color: white;
    }
    .priority-medium {
        background: #ffc107;
        color: #000;
    }
    .priority-low {
        background: #6c757d;
        color: white;
    }
    @keyframes blink {
        0%, 50% { opacity: 1; }
        51%, 100% { opacity: 0.5; }
    }
    .filter-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .expiry-warning {
        background: #fff3cd;
        border: 1px solid #ffeaa7;
        border-radius: 8px;
        padding: 8px;
        font-size: 0.85rem;
        color: #856404;
    }
    .expired {
        opacity: 0.6;
        background: #f8f9fa;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="fas fa-bullhorn me-2 text-primary"></i>
            إدارة الأخبار والإعلانات
        </h1>
        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            إضافة خبر جديد
        </a>
    </div>

    <!-- Quick Actions -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="btn-group me-3" role="group">
                <a href="{{ route('admin.news.index') }}" 
                   class="btn {{ !request('filter') ? 'btn-primary' : 'btn-outline-primary' }}">
                    <i class="fas fa-list me-1"></i>جميع الأخبار
                </a>
                <a href="{{ route('admin.news.urgent') }}" 
                   class="btn {{ request('filter') === 'urgent' ? 'btn-danger' : 'btn-outline-danger' }}">
                    <i class="fas fa-exclamation-triangle me-1"></i>عاجل
                </a>
                <a href="{{ route('admin.news.expired') }}" 
                   class="btn {{ request('filter') === 'expired' ? 'btn-warning' : 'btn-outline-warning' }}">
                    <i class="fas fa-clock me-1"></i>منتهية الصلاحية
                </a>
            </div>
        </div>
    </div>

    <!-- Search and Filter Section -->
    <div class="card filter-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.news.index') }}" class="row g-3">
                <div class="col-md-3">
                    <label class="form-label">البحث</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" 
                               placeholder="البحث في العنوان أو المحتوى..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-2">
                    <label class="form-label">النوع</label>
                    <select name="type" class="form-select">
                        <option value="">جميع الأنواع</option>
                        <option value="news" {{ request('type') === 'news' ? 'selected' : '' }}>خبر</option>
                        <option value="announcement" {{ request('type') === 'announcement' ? 'selected' : '' }}>إعلان</option>
                        <option value="event" {{ request('type') === 'event' ? 'selected' : '' }}>فعالية</option>
                        <option value="notice" {{ request('type') === 'notice' ? 'selected' : '' }}>تنويه</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">الأولوية</label>
                    <select name="priority" class="form-select">
                        <option value="">جميع الأولويات</option>
                        <option value="urgent" {{ request('priority') === 'urgent' ? 'selected' : '' }}>عاجل</option>
                        <option value="high" {{ request('priority') === 'high' ? 'selected' : '' }}>عالية</option>
                        <option value="medium" {{ request('priority') === 'medium' ? 'selected' : '' }}>متوسطة</option>
                        <option value="low" {{ request('priority') === 'low' ? 'selected' : '' }}>منخفضة</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">الحالة</label>
                    <select name="status" class="form-select">
                        <option value="">جميع الحالات</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>منشور</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>مسودة</option>
                        <option value="scheduled" {{ request('status') === 'scheduled' ? 'selected' : '' }}>مجدول</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>بحث
                        </button>
                        <a href="{{ route('admin.news.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-1"></i>إعادة تعيين
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-white-50 small">إجمالي الأخبار</div>
                            <div class="h4 mb-0">{{ $news->total() }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-bullhorn fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-white-50 small">الأخبار العاجلة</div>
                            <div class="h4 mb-0">{{ $news->where('priority', 'urgent')->count() }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-exclamation-triangle fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-white-50 small">الأخبار المنشورة</div>
                            <div class="h4 mb-0">{{ $news->where('is_published', true)->count() }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-white-50 small">منتهية الصلاحية</div>
                            <div class="h4 mb-0">{{ $news->where('expires_at', '<', now())->count() }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clock fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- News Grid -->
    <div class="row">
        @forelse($news as $newsItem)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card news-card {{ $newsItem->priority === 'urgent' ? 'urgent' : '' }} {{ $newsItem->expires_at && $newsItem->expires_at->isPast() ? 'expired' : '' }}">
                    <div class="position-relative">
                        @if($newsItem->featured_image)
                            <img src="{{ Storage::url($newsItem->featured_image) }}" 
                                 alt="{{ $newsItem->title }}" 
                                 class="news-image">
                        @else
                            <div class="news-image d-flex align-items-center justify-content-center">
                                <i class="fas fa-bullhorn fa-3x text-white"></i>
                            </div>
                        @endif
                        
                        <!-- Priority Badge -->
                        <div class="position-absolute top-0 start-0 m-2">
                            <span class="priority-badge priority-{{ $newsItem->priority }}">
                                @switch($newsItem->priority)
                                    @case('urgent')
                                        <i class="fas fa-exclamation-triangle me-1"></i>عاجل
                                        @break
                                    @case('high')
                                        <i class="fas fa-arrow-up me-1"></i>عالية
                                        @break
                                    @case('medium')
                                        <i class="fas fa-minus me-1"></i>متوسطة
                                        @break
                                    @case('low')
                                        <i class="fas fa-arrow-down me-1"></i>منخفضة
                                        @break
                                @endswitch
                            </span>
                        </div>
                        
                        <!-- Status Badges -->
                        <div class="position-absolute top-0 end-0 m-2">
                            @if(!$newsItem->is_published)
                                <span class="badge bg-secondary mb-1">مسودة</span>
                            @endif
                            @if($newsItem->scheduled_at && $newsItem->scheduled_at->isFuture())
                                <span class="badge bg-info mb-1">مجدول</span>
                            @endif
                            @if($newsItem->expires_at && $newsItem->expires_at->isPast())
                                <span class="badge bg-warning mb-1">منتهي</span>
                            @endif
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="position-absolute bottom-0 end-0 m-2">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-light btn-sm" 
                                        onclick="togglePublished({{ $newsItem->id }})"
                                        title="تبديل النشر">
                                    <i class="fas fa-eye {{ $newsItem->is_published ? 'text-success' : 'text-muted' }}"></i>
                                </button>
                                <button class="btn btn-light btn-sm" 
                                        onclick="toggleNotification({{ $newsItem->id }})"
                                        title="تبديل الإشعار">
                                    <i class="fas fa-bell {{ $newsItem->send_notification ? 'text-warning' : 'text-muted' }}"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <div class="d-flex justify-content-between align-items-start mb-2">
                            <span class="badge bg-light text-dark">{{ ucfirst($newsItem->type) }}</span>
                        </div>
                        
                        <h5 class="card-title">{{ Str::limit($newsItem->title, 45) }}</h5>
                        <p class="card-text flex-grow-1">
                            {{ Str::limit($newsItem->summary ?: strip_tags($newsItem->content), 100) }}
                        </p>
                        
                        <!-- Expiry Warning -->
                        @if($newsItem->expires_at)
                            <div class="expiry-warning mb-2">
                                <i class="fas fa-clock me-1"></i>
                                @if($newsItem->expires_at->isPast())
                                    انتهت صلاحية هذا الخبر
                                @else
                                    ينتهي في {{ $newsItem->expires_at->diffForHumans() }}
                                @endif
                            </div>
                        @endif
                        
                        <!-- Meta Information -->
                        <div class="news-meta">
                            <div class="meta-item">
                                <i class="fas fa-eye"></i>
                                {{ number_format($newsItem->views_count ?? 0) }}
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                {{ $newsItem->created_at->format('Y/m/d') }}
                            </div>
                            @if($newsItem->scheduled_at)
                            <div class="meta-item">
                                <i class="fas fa-clock"></i>
                                {{ $newsItem->scheduled_at->format('H:i') }}
                            </div>
                            @endif
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="mt-3">
                            <div class="btn-group w-100">
                                <a href="{{ route('admin.news.show', $newsItem) }}" 
                                   class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-eye me-1"></i>عرض
                                </a>
                                <a href="{{ route('admin.news.edit', $newsItem) }}" 
                                   class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit me-1"></i>تعديل
                                </a>
                                @if($newsItem->priority === 'urgent')
                                    <button class="btn btn-outline-primary btn-sm" 
                                            onclick="sendNotification({{ $newsItem->id }})">
                                        <i class="fas fa-paper-plane me-1"></i>إشعار
                                    </button>
                                @endif
                                <button class="btn btn-outline-danger btn-sm" 
                                        onclick="deleteNews({{ $newsItem->id }})">
                                    <i class="fas fa-trash me-1"></i>حذف
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-bullhorn fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">لا توجد أخبار</h5>
                        <p class="text-muted">لم يتم العثور على أي أخبار. قم بإضافة خبر جديد للبدء.</p>
                        <a href="{{ route('admin.news.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>إضافة خبر جديد
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($news->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $news->appends(request()->query())->links() }}
        </div>
    @endif
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تأكيد الحذف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                هل أنت متأكد من حذف هذا الخبر؟ هذا الإجراء لا يمكن التراجع عنه.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">حذف</button>
            </div>
        </div>
    </div>
</div>

<!-- Send Notification Modal -->
<div class="modal fade" id="notificationModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">إرسال إشعار</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                هل تريد إرسال إشعار فوري للمستخدمين حول هذا الخبر العاجل؟
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-primary" id="confirmNotification">إرسال الإشعار</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let newsToDelete = null;
let newsToNotify = null;

function deleteNews(id) {
    newsToDelete = id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

function sendNotification(id) {
    newsToNotify = id;
    new bootstrap.Modal(document.getElementById('notificationModal')).show();
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (newsToDelete) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/news/${newsToDelete}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
});

document.getElementById('confirmNotification').addEventListener('click', function() {
    if (newsToNotify) {
        fetch(`/admin/news/${newsToNotify}/send-notification`, {
            method: 'POST',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Content-Type': 'application/json',
            },
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                alert('تم إرسال الإشعار بنجاح');
                bootstrap.Modal.getInstance(document.getElementById('notificationModal')).hide();
            } else {
                alert('حدث خطأ أثناء إرسال الإشعار');
            }
        })
        .catch(error => {
            console.error('Error:', error);
            alert('حدث خطأ أثناء إرسال الإشعار');
        });
    }
});

function togglePublished(id) {
    fetch(`/admin/news/${id}/toggle-published`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}

function toggleNotification(id) {
    fetch(`/admin/news/${id}/toggle-notification`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
@endpush
