@extends('layouts.admin')

@section('title', 'إدارة المقالات')

@push('styles')
<style>
    .article-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        height: 100%;
    }
    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .article-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        background: linear-gradient(135deg, var(--islamic-teal), var(--islamic-gold));
    }
    .article-meta {
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
    .filter-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .status-badge {
        font-size: 0.75rem;
        padding: 4px 8px;
    }
    .reading-time {
        background: var(--islamic-gold);
        color: white;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.75rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="fas fa-newspaper me-2 text-primary"></i>
            إدارة المقالات
        </h1>
        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            إضافة مقال جديد
        </a>
    </div>

    <!-- Search and Filter Section -->
    <div class="card filter-card mb-4">
        <div class="card-body">
            <form method="GET" action="{{ route('admin.articles.index') }}" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">البحث</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" 
                               placeholder="البحث في العنوان أو المحتوى..."
                               value="{{ request('search') }}">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">التصنيف</label>
                    <select name="category" class="form-select">
                        <option value="">جميع التصنيفات</option>
                        <option value="إسلاميات" {{ request('category') === 'إسلاميات' ? 'selected' : '' }}>إسلاميات</option>
                        <option value="فقه" {{ request('category') === 'فقه' ? 'selected' : '' }}>فقه</option>
                        <option value="عقيدة" {{ request('category') === 'عقيدة' ? 'selected' : '' }}>عقيدة</option>
                        <option value="تفسير" {{ request('category') === 'تفسير' ? 'selected' : '' }}>تفسير</option>
                        <option value="حديث" {{ request('category') === 'حديث' ? 'selected' : '' }}>حديث</option>
                        <option value="سيرة" {{ request('category') === 'سيرة' ? 'selected' : '' }}>سيرة</option>
                        <option value="أخلاق" {{ request('category') === 'أخلاق' ? 'selected' : '' }}>أخلاق</option>
                        <option value="دعوة" {{ request('category') === 'دعوة' ? 'selected' : '' }}>دعوة</option>
                        <option value="تربية" {{ request('category') === 'تربية' ? 'selected' : '' }}>تربية</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">الحالة</label>
                    <select name="status" class="form-select">
                        <option value="">جميع الحالات</option>
                        <option value="published" {{ request('status') === 'published' ? 'selected' : '' }}>منشور</option>
                        <option value="draft" {{ request('status') === 'draft' ? 'selected' : '' }}>مسودة</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>بحث
                        </button>
                        <a href="{{ route('admin.articles.index') }}" class="btn btn-outline-secondary">
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
                            <div class="text-white-50 small">إجمالي المقالات</div>
                            <div class="h4 mb-0">{{ $articles->total() }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-newspaper fa-2x text-white-50"></i>
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
                            <div class="text-white-50 small">المقالات المنشورة</div>
                            <div class="h4 mb-0">{{ $articles->where('is_published', true)->count() }}</div>
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
                            <div class="text-white-50 small">المقالات المميزة</div>
                            <div class="h4 mb-0">{{ $articles->where('is_featured', true)->count() }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-star fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-white-50 small">إجمالي المشاهدات</div>
                            <div class="h4 mb-0">{{ $articles->sum('views_count') }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-eye fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Articles Grid -->
    <div class="row">
        @forelse($articles as $article)
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card article-card">
                    <div class="position-relative">
                        @if($article->featured_image)
                            <img src="{{ Storage::url($article->featured_image) }}" 
                                 alt="{{ $article->title }}" 
                                 class="article-image">
                        @else
                            <div class="article-image d-flex align-items-center justify-content-center">
                                <i class="fas fa-newspaper fa-3x text-white"></i>
                            </div>
                        @endif
                        
                        <!-- Status Badges -->
                        <div class="position-absolute top-0 start-0 m-2">
                            @if($article->is_featured)
                                <span class="badge bg-warning status-badge">
                                    <i class="fas fa-star me-1"></i>مميز
                                </span>
                            @endif
                            @if(!$article->is_published)
                                <span class="badge bg-secondary status-badge">مسودة</span>
                            @endif
                        </div>
                        
                        <!-- Reading Time -->
                        @if($article->reading_time)
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="reading-time">
                                    <i class="fas fa-clock me-1"></i>{{ $article->reading_time }} دقيقة
                                </span>
                            </div>
                        @endif
                        
                        <!-- Quick Actions -->
                        <div class="position-absolute bottom-0 end-0 m-2">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-light btn-sm" 
                                        onclick="toggleFeatured({{ $article->id }})"
                                        title="تبديل المميز">
                                    <i class="fas fa-star {{ $article->is_featured ? 'text-warning' : '' }}"></i>
                                </button>
                                <button class="btn btn-light btn-sm" 
                                        onclick="togglePublished({{ $article->id }})"
                                        title="تبديل النشر">
                                    <i class="fas fa-eye {{ $article->is_published ? 'text-success' : 'text-muted' }}"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title">{{ Str::limit($article->title, 50) }}</h5>
                        <p class="card-text flex-grow-1">
                            {{ Str::limit(strip_tags($article->excerpt ?: $article->content), 120) }}
                        </p>
                        
                        <!-- Category -->
                        <div class="mb-2">
                            <span class="badge bg-light text-dark">{{ $article->category }}</span>
                        </div>
                        
                        <!-- Meta Information -->
                        <div class="article-meta">
                            <div class="meta-item">
                                <i class="fas fa-eye"></i>
                                {{ number_format($article->views_count) }}
                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                {{ $article->created_at->format('Y/m/d') }}
                            </div>
                            @if($article->published_at)
                            <div class="meta-item">
                                <i class="fas fa-globe"></i>
                                {{ $article->published_at->format('Y/m/d') }}
                            </div>
                            @endif
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="mt-3">
                            <div class="btn-group w-100">
                                <a href="{{ route('admin.articles.show', $article) }}" 
                                   class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-eye me-1"></i>عرض
                                </a>
                                <a href="{{ route('admin.articles.edit', $article) }}" 
                                   class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit me-1"></i>تعديل
                                </a>
                                <a href="{{ route('admin.articles.preview', $article) }}" 
                                   class="btn btn-outline-success btn-sm" target="_blank">
                                    <i class="fas fa-external-link-alt me-1"></i>معاينة
                                </a>
                                <button class="btn btn-outline-danger btn-sm" 
                                        onclick="deleteArticle({{ $article->id }})">
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
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">لا توجد مقالات</h5>
                        <p class="text-muted">لم يتم العثور على أي مقالات. قم بإضافة مقال جديد للبدء.</p>
                        <a href="{{ route('admin.articles.create') }}" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>إضافة مقال جديد
                        </a>
                    </div>
                </div>
            </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($articles->hasPages())
        <div class="d-flex justify-content-center mt-4">
            {{ $articles->appends(request()->query())->links() }}
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
                هل أنت متأكد من حذف هذا المقال؟ هذا الإجراء لا يمكن التراجع عنه.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">حذف</button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
let articleToDelete = null;

function deleteArticle(id) {
    articleToDelete = id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (articleToDelete) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/articles/${articleToDelete}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    }
});

function toggleFeatured(id) {
    fetch(`/admin/articles/${id}/toggle-featured`, {
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

function togglePublished(id) {
    fetch(`/admin/articles/${id}/toggle-published`, {
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
