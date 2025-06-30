@extends('layouts.admin')

@section('title', 'تفاصيل الخبر')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="mb-2 text-primary">
                        <i class="fas fa-newspaper me-2"></i>
                        {{ $news->title }}
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.news.index') }}">الأخبار</a></li>
                            <li class="breadcrumb-item active">تفاصيل الخبر</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2 flex-wrap">
                    @if($news->is_published)
                        <span class="badge bg-success fs-6">منشور</span>
                    @else
                        <span class="badge bg-warning fs-6">مسودة</span>
                    @endif
                    @if($news->is_featured)
                        <span class="badge bg-warning fs-6">مميز</span>
                    @endif
                    @if($news->is_urgent)
                        <span class="badge bg-danger fs-6">عاجل</span>
                    @endif
                    <span class="badge bg-info fs-6">{{ $news->priority }}</span>
                    <span class="badge bg-secondary fs-6">{{ $news->type }}</span>
                </div>
            </div>
        </div>
    </div>

    <!-- Expiration Warning -->
    @if($news->expires_at && $news->expires_at->isPast())
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-danger d-flex align-items-center">
                <i class="fas fa-exclamation-triangle me-2"></i>
                <div>
                    <strong>تنبيه:</strong> انتهت صلاحية هذا الخبر في {{ $news->expires_at->format('Y/m/d H:i') }}
                </div>
            </div>
        </div>
    </div>
    @elseif($news->expires_at && $news->expires_at->diffInDays() <= 3)
    <div class="row mb-4">
        <div class="col-12">
            <div class="alert alert-warning d-flex align-items-center">
                <i class="fas fa-clock me-2"></i>
                <div>
                    <strong>تنبيه:</strong> ستنتهي صلاحية هذا الخبر في {{ $news->expires_at->format('Y/m/d H:i') }}
                    (خلال {{ $news->expires_at->diffForHumans() }})
                </div>
            </div>
        </div>
    </div>
    @endif

    <div class="row">
        <div class="col-md-8">
            <!-- News Content -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">محتوى الخبر</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-light btn-sm">
                            <i class="fas fa-edit me-1"></i>
                            تعديل
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($news->summary)
                    <div class="alert alert-info">
                        <h6 class="alert-heading">ملخص الخبر:</h6>
                        <p class="mb-0">{{ $news->summary }}</p>
                    </div>
                    @endif

                    <div class="news-content">
                        {!! nl2br(e($news->content)) !!}
                    </div>

                    @if($news->location)
                    <div class="mt-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-map-marker-alt text-danger me-2"></i>
                            <strong>المكان:</strong>
                            <span class="ms-2">{{ $news->location }}</span>
                        </div>
                    </div>
                    @endif

                    @if($news->external_link)
                    <div class="mt-3">
                        <div class="d-flex align-items-center">
                            <i class="fas fa-external-link-alt text-primary me-2"></i>
                            <strong>رابط خارجي:</strong>
                            <a href="{{ $news->external_link }}" target="_blank" class="ms-2">
                                {{ $news->external_link }}
                                <i class="fas fa-external-link-alt ms-1"></i>
                            </a>
                        </div>
                    </div>
                    @endif

                    @if($news->tags && count($news->tags) > 0)
                    <hr>
                    <div class="d-flex flex-wrap gap-2">
                        <strong class="me-2">العلامات:</strong>
                        @foreach($news->tags as $tag)
                            <span class="badge bg-secondary">{{ $tag }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- News Images -->
            @if($news->images && count($news->images) > 0)
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-images me-2"></i>
                        صور الخبر ({{ count($news->images) }})
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row">
                        @foreach($news->images as $index => $image)
                        <div class="col-md-4 mb-3">
                            <div class="card">
                                <img src="{{ asset('storage/' . $image) }}" 
                                     alt="صورة {{ $index + 1 }}" 
                                     class="card-img-top" 
                                     style="height: 200px; object-fit: cover;"
                                     data-bs-toggle="modal" 
                                     data-bs-target="#imageModal{{ $index }}"
                                     style="cursor: pointer;">
                                <div class="card-body p-2 text-center">
                                    <small class="text-muted">صورة {{ $index + 1 }}</small>
                                </div>
                            </div>

                            <!-- Image Modal -->
                            <div class="modal fade" id="imageModal{{ $index }}" tabindex="-1">
                                <div class="modal-dialog modal-lg">
                                    <div class="modal-content">
                                        <div class="modal-header">
                                            <h5 class="modal-title">صورة {{ $index + 1 }}</h5>
                                            <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
                                        </div>
                                        <div class="modal-body text-center">
                                            <img src="{{ asset('storage/' . $image) }}" 
                                                 alt="صورة {{ $index + 1 }}" 
                                                 class="img-fluid">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif

            <!-- News Attachments -->
            @if($news->attachments && count($news->attachments) > 0)
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-paperclip me-2"></i>
                        مرفقات الخبر ({{ count($news->attachments) }})
                    </h6>
                </div>
                <div class="card-body">
                    <div class="list-group">
                        @foreach($news->attachments as $index => $attachment)
                        <div class="list-group-item d-flex justify-content-between align-items-center">
                            <div class="d-flex align-items-center">
                                <i class="fas fa-file me-2 text-primary"></i>
                                <span>{{ basename($attachment) }}</span>
                            </div>
                            <a href="{{ asset('storage/' . $attachment) }}" 
                               class="btn btn-sm btn-outline-primary" 
                               download>
                                <i class="fas fa-download me-1"></i>
                                تحميل
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <!-- News Statistics -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        إحصائيات الخبر
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-3">
                        <div class="col-6">
                            <div class="border-end">
                                <h3 class="text-primary mb-1">{{ number_format($news->views_count) }}</h3>
                                <small class="text-muted">المشاهدات</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h3 class="text-success mb-1">{{ $news->type }}</h3>
                            <small class="text-muted">نوع الخبر</small>
                        </div>
                    </div>

                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">تاريخ الإنشاء:</span>
                            <span class="fw-bold">{{ $news->created_at->format('Y/m/d H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">آخر تحديث:</span>
                            <span class="fw-bold">{{ $news->updated_at->format('Y/m/d H:i') }}</span>
                        </div>
                        @if($news->published_at)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">تاريخ النشر:</span>
                            <span class="fw-bold text-success">{{ $news->published_at->format('Y/m/d H:i') }}</span>
                        </div>
                        @endif
                        @if($news->starts_at)
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">تاريخ البداية:</span>
                            <span class="fw-bold text-info">{{ $news->starts_at->format('Y/m/d H:i') }}</span>
                        </div>
                        @endif
                        @if($news->expires_at)
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">تاريخ الانتهاء:</span>
                            <span class="fw-bold {{ $news->expires_at->isPast() ? 'text-danger' : 'text-warning' }}">
                                {{ $news->expires_at->format('Y/m/d H:i') }}
                            </span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- News Details -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        تفاصيل الخبر
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>نوع الخبر:</strong>
                        <span class="badge bg-primary">{{ $news->type }}</span>
                    </div>

                    <div class="mb-3">
                        <strong>الأولوية:</strong>
                        @php
                            $priorityColor = match($news->priority) {
                                'منخفضة' => 'secondary',
                                'عادية' => 'primary',
                                'عالية' => 'warning',
                                'عاجلة' => 'danger',
                                default => 'secondary'
                            };
                        @endphp
                        <span class="badge bg-{{ $priorityColor }}">{{ $news->priority }}</span>
                    </div>

                    <div class="mb-3">
                        <strong>الحالة:</strong>
                        <div class="mt-1">
                            @if($news->is_published)
                                <span class="badge bg-success">منشور</span>
                            @else
                                <span class="badge bg-warning">مسودة</span>
                            @endif
                            
                            @if($news->is_featured)
                                <span class="badge bg-warning">مميز</span>
                            @endif
                            
                            @if($news->is_urgent)
                                <span class="badge bg-danger">عاجل</span>
                            @endif
                            
                            @if($news->allow_comments)
                                <span class="badge bg-info">يسمح بالتعليقات</span>
                            @else
                                <span class="badge bg-secondary">لا يسمح بالتعليقات</span>
                            @endif

                            @if($news->send_notification)
                                <span class="badge bg-success">يرسل إشعار</span>
                            @endif
                        </div>
                    </div>

                    @if($news->images && count($news->images) > 0)
                    <div class="mb-3">
                        <strong>الصور:</strong>
                        <span class="text-muted">{{ count($news->images) }} صورة</span>
                    </div>
                    @endif

                    @if($news->attachments && count($news->attachments) > 0)
                    <div class="mb-0">
                        <strong>المرفقات:</strong>
                        <span class="text-muted">{{ count($news->attachments) }} ملف</span>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-bolt me-2"></i>
                        إجراءات سريعة
                    </h6>
                </div>
                <div class="card-body">
                    <div class="d-grid gap-2">
                        <a href="{{ route('admin.news.edit', $news) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>
                            تعديل الخبر
                        </a>

                        @if($news->is_published)
                            <form action="{{ route('admin.news.toggle-published', $news) }}" 
                                  method="POST" 
                                  class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-archive me-2"></i>
                                    تحويل لمسودة
                                </button>
                            </form>
                        @else
                            <form action="{{ route('admin.news.toggle-published', $news) }}" 
                                  method="POST" 
                                  class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    نشر الخبر
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.news.toggle-featured', $news) }}" 
                              method="POST" 
                              class="d-inline">
                            @csrf
                            @method('PATCH')
                            @if($news->is_featured)
                                <button type="submit" class="btn btn-outline-warning w-100">
                                    <i class="fas fa-star-half-alt me-2"></i>
                                    إلغاء التمييز
                                </button>
                            @else
                                <button type="submit" class="btn btn-warning w-100">
                                    <i class="fas fa-star me-2"></i>
                                    جعل مميز
                                </button>
                            @endif
                        </form>

                        <form action="{{ route('admin.news.toggle-urgent', $news) }}" 
                              method="POST" 
                              class="d-inline">
                            @csrf
                            @method('PATCH')
                            @if($news->is_urgent)
                                <button type="submit" class="btn btn-outline-danger w-100">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    إلغاء العاجل
                                </button>
                            @else
                                <button type="submit" class="btn btn-danger w-100">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    جعل عاجل
                                </button>
                            @endif
                        </form>

                        <hr>

                        <form action="{{ route('admin.news.destroy', $news) }}" 
                              method="POST" 
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا الخبر؟ لا يمكن التراجع عن هذا الإجراء.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>
                                حذف الخبر
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Back Button -->
    <div class="row mt-4">
        <div class="col-12">
            <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-right me-2"></i>
                العودة إلى قائمة الأخبار
            </a>
        </div>
    </div>
</div>

<style>
.news-content {
    line-height: 1.8;
    font-size: 1.1rem;
    color: #333;
}

.news-content p {
    margin-bottom: 1rem;
}

.badge {
    font-size: 0.8em;
}

.card-img-top {
    cursor: pointer;
    transition: transform 0.2s;
}

.card-img-top:hover {
    transform: scale(1.05);
}
</style>
@endsection
