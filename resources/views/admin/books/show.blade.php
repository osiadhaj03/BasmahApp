@extends('layouts.admin')

@section('title', 'عرض الكتاب - ' . $book->title)

@push('styles')
<style>
    .book-hero {
        background: linear-gradient(135deg, var(--islamic-teal) 0%, var(--islamic-dark-teal) 100%);
        color: white;
        border-radius: 20px;
        padding: 30px;
        margin-bottom: 30px;
        position: relative;
        overflow: hidden;
    }
    .book-hero::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-image: repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(212, 168, 83, 0.1) 10px, rgba(212, 168, 83, 0.1) 20px);
        pointer-events: none;
    }
    .book-cover-large {
        max-width: 250px;
        border-radius: 15px;
        box-shadow: 0 10px 30px rgba(0,0,0,0.3);
    }
    .stat-card {
        background: white;
        border-radius: 15px;
        padding: 20px;
        text-align: center;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        transition: transform 0.3s ease;
    }
    .stat-card:hover {
        transform: translateY(-5px);
    }
    .stat-icon {
        width: 60px;
        height: 60px;
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 15px;
        font-size: 1.5rem;
    }
    .action-card {
        background: rgba(255, 255, 255, 0.95);
        border: 1px solid rgba(212, 168, 83, 0.2);
        border-radius: 15px;
        padding: 20px;
        margin-bottom: 20px;
    }
    .tag-item {
        background: var(--islamic-gold);
        color: white;
        padding: 5px 12px;
        border-radius: 20px;
        font-size: 0.85rem;
        margin: 2px;
        display: inline-block;
    }
    .rating-stars {
        color: #ffc107;
        font-size: 1.2rem;
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <!-- Header Actions -->
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="fas fa-book me-2 text-primary"></i>
            عرض الكتاب
        </h1>
        <div>
            <a href="{{ route('admin.books.edit', $book) }}" class="btn btn-warning me-2">
                <i class="fas fa-edit me-2"></i>تعديل
            </a>
            <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                <i class="fas fa-arrow-right me-2"></i>العودة للقائمة
            </a>
        </div>
    </div>

    <!-- Book Hero Section -->
    <div class="book-hero">
        <div class="row align-items-center">
            <div class="col-md-3 text-center">
                @if($book->cover_image)
                    <img src="{{ Storage::url($book->cover_image) }}" 
                         alt="{{ $book->title }}" 
                         class="book-cover-large">
                @else
                    <div class="book-cover-large d-flex align-items-center justify-content-center bg-light text-dark">
                        <i class="fas fa-book fa-5x"></i>
                    </div>
                @endif
            </div>
            <div class="col-md-9">
                <div class="d-flex align-items-start justify-content-between">
                    <div class="flex-grow-1">
                        <h1 class="display-6 mb-3">{{ $book->title }}</h1>
                        <p class="h5 mb-3">
                            <i class="fas fa-user me-2"></i>{{ $book->author }}
                        </p>
                        
                        <!-- Badges -->
                        <div class="mb-3">
                            <span class="badge bg-light text-dark fs-6 me-2">{{ $book->category }}</span>
                            @if($book->is_featured)
                                <span class="badge bg-warning fs-6 me-2">
                                    <i class="fas fa-star me-1"></i>مميز
                                </span>
                            @endif
                            @if($book->is_published)
                                <span class="badge bg-success fs-6 me-2">منشور</span>
                            @else
                                <span class="badge bg-secondary fs-6 me-2">مسودة</span>
                            @endif
                            @if($book->is_downloadable)
                                <span class="badge bg-info fs-6">قابل للتحميل</span>
                            @endif
                        </div>
                        
                        <!-- Rating -->
                        @if($book->rating)
                            <div class="rating-stars mb-3">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="fas fa-star {{ $i <= $book->rating ? '' : 'text-muted' }}"></i>
                                @endfor
                                <span class="text-white ms-2">({{ $book->rating }}/5)</span>
                            </div>
                        @endif
                        
                        <p class="lead">{{ $book->description }}</p>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- Main Content -->
        <div class="col-lg-8">
            <!-- Book Details -->
            <div class="action-card">
                <h4 class="section-title mb-4">
                    <i class="fas fa-info-circle me-2"></i>تفاصيل الكتاب
                </h4>
                
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td><strong>المؤلف:</strong></td>
                                <td>{{ $book->author }}</td>
                            </tr>
                            <tr>
                                <td><strong>التصنيف:</strong></td>
                                <td><span class="badge bg-primary">{{ $book->category }}</span></td>
                            </tr>
                            <tr>
                                <td><strong>اللغة:</strong></td>
                                <td>{{ $book->language }}</td>
                            </tr>
                            @if($book->isbn)
                            <tr>
                                <td><strong>رقم ISBN:</strong></td>
                                <td><code>{{ $book->isbn }}</code></td>
                            </tr>
                            @endif
                            @if($book->publication_year)
                            <tr>
                                <td><strong>سنة النشر:</strong></td>
                                <td>{{ $book->publication_year }}</td>
                            </tr>
                            @endif
                        </table>
                    </div>
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            @if($book->pages_count)
                            <tr>
                                <td><strong>عدد الصفحات:</strong></td>
                                <td>{{ number_format($book->pages_count) }} صفحة</td>
                            </tr>
                            @endif
                            @if($book->file_size)
                            <tr>
                                <td><strong>حجم الملف:</strong></td>
                                <td>{{ number_format($book->file_size / 1024 / 1024, 1) }} MB</td>
                            </tr>
                            @endif
                            <tr>
                                <td><strong>تاريخ الإضافة:</strong></td>
                                <td>{{ $book->created_at->format('Y/m/d H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>آخر تحديث:</strong></td>
                                <td>{{ $book->updated_at->format('Y/m/d H:i') }}</td>
                            </tr>
                            <tr>
                                <td><strong>أضيف بواسطة:</strong></td>
                                <td>{{ $book->addedBy?->name ?? 'غير محدد' }}</td>
                            </tr>
                        </table>
                    </div>
                </div>
            </div>

            <!-- Tags Section -->
            @if($book->tags && count($book->tags) > 0)
            <div class="action-card">
                <h4 class="section-title mb-3">
                    <i class="fas fa-tags me-2"></i>الكلمات المفتاحية
                </h4>
                <div>
                    @foreach($book->tags as $tag)
                        <span class="tag-item">{{ $tag }}</span>
                    @endforeach
                </div>
            </div>
            @endif

            <!-- File Information -->
            @if($book->file_path)
            <div class="action-card">
                <h4 class="section-title mb-3">
                    <i class="fas fa-file me-2"></i>معلومات الملف
                </h4>
                
                <div class="d-flex align-items-center justify-content-between p-3 bg-light rounded">
                    <div class="d-flex align-items-center">
                        <i class="fas fa-file-pdf fa-2x text-danger me-3"></i>
                        <div>
                            <h6 class="mb-1">{{ basename($book->file_path) }}</h6>
                            <small class="text-muted">
                                الحجم: {{ $book->file_size ? number_format($book->file_size / 1024 / 1024, 1) . ' MB' : 'غير محدد' }}
                            </small>
                        </div>
                    </div>
                    <div>
                        @if($book->is_downloadable)
                            <a href="{{ route('admin.books.download', $book) }}" 
                               class="btn btn-success">
                                <i class="fas fa-download me-2"></i>تحميل
                            </a>
                        @else
                            <span class="badge bg-warning">غير قابل للتحميل</span>
                        @endif
                    </div>
                </div>
            </div>
            @endif
        </div>

        <!-- Sidebar -->
        <div class="col-lg-4">
            <!-- Statistics -->
            <div class="action-card">
                <h4 class="section-title mb-4">
                    <i class="fas fa-chart-bar me-2"></i>الإحصائيات
                </h4>
                
                <div class="row">
                    <div class="col-6 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-primary text-white">
                                <i class="fas fa-download"></i>
                            </div>
                            <h5 class="mb-1">{{ number_format($book->download_count) }}</h5>
                            <small class="text-muted">تحميلات</small>
                        </div>
                    </div>
                    <div class="col-6 mb-3">
                        <div class="stat-card">
                            <div class="stat-icon bg-success text-white">
                                <i class="fas fa-eye"></i>
                            </div>
                            <h5 class="mb-1">{{ number_format($book->views_count ?? 0) }}</h5>
                            <small class="text-muted">مشاهدات</small>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Quick Actions -->
            <div class="action-card">
                <h4 class="section-title mb-3">
                    <i class="fas fa-cog me-2"></i>إجراءات سريعة
                </h4>
                
                <div class="d-grid gap-2">
                    <button class="btn btn-outline-warning" 
                            onclick="toggleFeatured({{ $book->id }})">
                        <i class="fas fa-star me-2"></i>
                        {{ $book->is_featured ? 'إزالة من المميز' : 'إضافة للمميز' }}
                    </button>
                    
                    <button class="btn btn-outline-info" 
                            onclick="togglePublished({{ $book->id }})">
                        <i class="fas fa-eye me-2"></i>
                        {{ $book->is_published ? 'إخفاء' : 'نشر' }}
                    </button>
                    
                    <button class="btn btn-outline-success" 
                            onclick="toggleDownloadable({{ $book->id }})">
                        <i class="fas fa-download me-2"></i>
                        {{ $book->is_downloadable ? 'منع التحميل' : 'السماح بالتحميل' }}
                    </button>
                    
                    <hr>
                    
                    <a href="{{ route('admin.books.edit', $book) }}" 
                       class="btn btn-warning">
                        <i class="fas fa-edit me-2"></i>تعديل الكتاب
                    </a>
                    
                    <button class="btn btn-danger" 
                            onclick="deleteBook({{ $book->id }})">
                        <i class="fas fa-trash me-2"></i>حذف الكتاب
                    </button>
                </div>
            </div>

            <!-- Publishing Info -->
            <div class="action-card">
                <h4 class="section-title mb-3">
                    <i class="fas fa-info me-2"></i>معلومات النشر
                </h4>
                
                <div class="list-group list-group-flush">
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>الحالة:</span>
                        <span class="badge {{ $book->is_published ? 'bg-success' : 'bg-secondary' }}">
                            {{ $book->is_published ? 'منشور' : 'مسودة' }}
                        </span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>مميز:</span>
                        <span class="badge {{ $book->is_featured ? 'bg-warning' : 'bg-light text-dark' }}">
                            {{ $book->is_featured ? 'نعم' : 'لا' }}
                        </span>
                    </div>
                    <div class="list-group-item d-flex justify-content-between align-items-center">
                        <span>قابل للتحميل:</span>
                        <span class="badge {{ $book->is_downloadable ? 'bg-info' : 'bg-light text-dark' }}">
                            {{ $book->is_downloadable ? 'نعم' : 'لا' }}
                        </span>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
                <div class="text-center">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <h5>هل أنت متأكد من حذف هذا الكتاب؟</h5>
                    <p class="text-muted">سيتم حذف الكتاب وجميع الملفات المرتبطة به نهائياً. هذا الإجراء لا يمكن التراجع عنه.</p>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">
                    <i class="fas fa-trash me-2"></i>حذف نهائياً
                </button>
            </div>
        </div>
    </div>
</div>
@endsection

@push('scripts')
<script>
function toggleFeatured(id) {
    fetch(`/admin/books/${id}/toggle-featured`, {
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
        } else {
            alert('حدث خطأ أثناء تحديث الكتاب');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء تحديث الكتاب');
    });
}

function togglePublished(id) {
    fetch(`/admin/books/${id}/toggle-published`, {
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
        } else {
            alert('حدث خطأ أثناء تحديث الكتاب');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء تحديث الكتاب');
    });
}

function toggleDownloadable(id) {
    fetch(`/admin/books/${id}/toggle-downloadable`, {
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
        } else {
            alert('حدث خطأ أثناء تحديث الكتاب');
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ أثناء تحديث الكتاب');
    });
}

function deleteBook(id) {
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
    
    document.getElementById('confirmDelete').onclick = function() {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/books/${id}`;
        form.innerHTML = `
            @csrf
            @method('DELETE')
        `;
        document.body.appendChild(form);
        form.submit();
    };
}
</script>
@endpush
