@extends('layouts.admin')

@section('title', 'تفاصيل المقال')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-start">
                <div>
                    <h2 class="mb-2 text-primary">
                        <i class="fas fa-newspaper me-2"></i>
                        {{ $article->title }}
                    </h2>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('admin.articles.index') }}">المقالات</a></li>
                            <li class="breadcrumb-item active">تفاصيل المقال</li>
                        </ol>
                    </nav>
                </div>
                <div class="d-flex gap-2">
                    @if($article->is_published)
                        <span class="badge bg-success fs-6">منشور</span>
                    @else
                        <span class="badge bg-warning fs-6">مسودة</span>
                    @endif
                    @if($article->is_featured)
                        <span class="badge bg-warning fs-6">مميز</span>
                    @endif
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <!-- Article Content -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">محتوى المقال</h5>
                    <div class="d-flex gap-2">
                        <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-light btn-sm">
                            <i class="fas fa-edit me-1"></i>
                            تعديل
                        </a>
                        <a href="{{ route('admin.articles.preview', $article) }}" 
                           class="btn btn-info btn-sm" 
                           target="_blank">
                            <i class="fas fa-eye me-1"></i>
                            معاينة
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    @if($article->featured_image)
                    <div class="text-center mb-4">
                        <img src="{{ asset('storage/' . $article->featured_image) }}" 
                             alt="{{ $article->title }}" 
                             class="img-fluid rounded shadow-sm" 
                             style="max-height: 300px;">
                    </div>
                    @endif

                    @if($article->excerpt)
                    <div class="alert alert-info">
                        <h6 class="alert-heading">مقتطف:</h6>
                        <p class="mb-0">{{ $article->excerpt }}</p>
                    </div>
                    @endif

                    <div class="article-content">
                        {!! nl2br(e($article->content)) !!}
                    </div>

                    @if($article->tags && count($article->tags) > 0)
                    <hr>
                    <div class="d-flex flex-wrap gap-2">
                        <strong class="me-2">العلامات:</strong>
                        @foreach($article->tags as $tag)
                            <span class="badge bg-secondary">{{ $tag }}</span>
                        @endforeach
                    </div>
                    @endif
                </div>
            </div>

            <!-- SEO Information -->
            @if($article->meta_title || $article->meta_description || $article->meta_keywords)
            <div class="card shadow-sm">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-search me-2"></i>
                        معلومات محرك البحث (SEO)
                    </h6>
                </div>
                <div class="card-body">
                    @if($article->meta_title)
                    <div class="mb-3">
                        <strong>العنوان في محرك البحث:</strong>
                        <p class="mb-0 text-muted">{{ $article->meta_title }}</p>
                    </div>
                    @endif

                    @if($article->meta_description)
                    <div class="mb-3">
                        <strong>الوصف في محرك البحث:</strong>
                        <p class="mb-0 text-muted">{{ $article->meta_description }}</p>
                    </div>
                    @endif

                    @if($article->meta_keywords)
                    <div class="mb-0">
                        <strong>الكلمات المفتاحية:</strong>
                        <p class="mb-0 text-muted">{{ $article->meta_keywords }}</p>
                    </div>
                    @endif
                </div>
            </div>
            @endif
        </div>

        <div class="col-md-4">
            <!-- Article Statistics -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-bar me-2"></i>
                        إحصائيات المقال
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center mb-3">
                        <div class="col-6">
                            <div class="border-end">
                                <h3 class="text-primary mb-1">{{ number_format($article->views_count) }}</h3>
                                <small class="text-muted">المشاهدات</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h3 class="text-success mb-1">{{ $article->reading_time }}</h3>
                            <small class="text-muted">دقيقة قراءة</small>
                        </div>
                    </div>

                    <div class="border-top pt-3">
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">تاريخ الإنشاء:</span>
                            <span class="fw-bold">{{ $article->created_at->format('Y/m/d H:i') }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span class="text-muted">آخر تحديث:</span>
                            <span class="fw-bold">{{ $article->updated_at->format('Y/m/d H:i') }}</span>
                        </div>
                        @if($article->published_at)
                        <div class="d-flex justify-content-between">
                            <span class="text-muted">تاريخ النشر:</span>
                            <span class="fw-bold text-success">{{ $article->published_at->format('Y/m/d H:i') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
            </div>

            <!-- Article Details -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        تفاصيل المقال
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <strong>الرابط (Slug):</strong>
                        <p class="mb-0 text-muted font-monospace">{{ $article->slug }}</p>
                    </div>

                    @if($article->category)
                    <div class="mb-3">
                        <strong>التصنيف:</strong>
                        <span class="badge bg-primary">{{ $article->category }}</span>
                    </div>
                    @endif

                    <div class="mb-3">
                        <strong>الحالة:</strong>
                        <div class="mt-1">
                            @if($article->is_published)
                                <span class="badge bg-success">منشور</span>
                            @else
                                <span class="badge bg-warning">مسودة</span>
                            @endif
                            
                            @if($article->is_featured)
                                <span class="badge bg-warning">مميز</span>
                            @endif
                            
                            @if($article->allow_comments)
                                <span class="badge bg-info">يسمح بالتعليقات</span>
                            @else
                                <span class="badge bg-secondary">لا يسمح بالتعليقات</span>
                            @endif
                        </div>
                    </div>

                    @if($article->featured_image)
                    <div class="mb-0">
                        <strong>الصورة المميزة:</strong>
                        <p class="mb-0 text-muted small">{{ basename($article->featured_image) }}</p>
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
                        <a href="{{ route('admin.articles.edit', $article) }}" class="btn btn-primary">
                            <i class="fas fa-edit me-2"></i>
                            تعديل المقال
                        </a>

                        <a href="{{ route('admin.articles.preview', $article) }}" 
                           class="btn btn-info" 
                           target="_blank">
                            <i class="fas fa-eye me-2"></i>
                            معاينة المقال
                        </a>

                        @if($article->is_published)
                            <form action="{{ route('admin.articles.toggle-published', $article) }}" 
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
                            <form action="{{ route('admin.articles.toggle-published', $article) }}" 
                                  method="POST" 
                                  class="d-inline">
                                @csrf
                                @method('PATCH')
                                <button type="submit" class="btn btn-success w-100">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    نشر المقال
                                </button>
                            </form>
                        @endif

                        <form action="{{ route('admin.articles.toggle-featured', $article) }}" 
                              method="POST" 
                              class="d-inline">
                            @csrf
                            @method('PATCH')
                            @if($article->is_featured)
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

                        <hr>

                        <form action="{{ route('admin.articles.destroy', $article) }}" 
                              method="POST" 
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا المقال؟ لا يمكن التراجع عن هذا الإجراء.')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger w-100">
                                <i class="fas fa-trash me-2"></i>
                                حذف المقال
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
            <a href="{{ route('admin.articles.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-right me-2"></i>
                العودة إلى قائمة المقالات
            </a>
        </div>
    </div>
</div>

<style>
.article-content {
    line-height: 1.8;
    font-size: 1.1rem;
    color: #333;
}

.article-content p {
    margin-bottom: 1rem;
}

.badge {
    font-size: 0.8em;
}
</style>
@endsection
