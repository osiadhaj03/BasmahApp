@extends('layouts.admin')

@section('title', 'عرض العالم: ' . $scholar->name)

@section('content')
@php
    $breadcrumb = [
        ['title' => 'الرئيسية', 'url' => route('admin.dashboard')],
        ['title' => 'العلماء', 'url' => route('admin.scholars.index')],
        ['title' => $scholar->name, 'url' => '']
    ];
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">
        <i class="fas fa-user-graduate text-info me-2"></i>
        {{ $scholar->name }}
        @if(!$scholar->is_active)
            <span class="badge bg-secondary ms-2">غير نشط</span>
        @endif
    </h2>
    <div class="btn-group">
        <a href="{{ route('admin.scholars.edit', $scholar) }}" class="btn btn-warning">
            <i class="fas fa-edit me-2"></i>
            تعديل
        </a>
        <button type="button" 
                class="btn btn-{{ $scholar->is_active ? 'secondary' : 'success' }}"
                onclick="toggleStatus({{ $scholar->id }}, {{ $scholar->is_active ? 'false' : 'true' }})">
            <i class="fas fa-{{ $scholar->is_active ? 'pause' : 'play' }} me-2"></i>
            {{ $scholar->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}
        </button>
        <a href="{{ route('admin.scholars.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right me-2"></i>
            العودة للقائمة
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-4">
        <!-- Scholar Image and Basic Info -->
        <div class="card">
            <div class="card-body text-center">
                @if($scholar->image)
                    <img src="{{ $scholar->image_url }}" 
                         alt="{{ $scholar->name }}" 
                         class="img-fluid rounded-circle mb-3" 
                         style="width: 150px; height: 150px; object-fit: cover;">
                @else
                    <div class="bg-secondary rounded-circle d-inline-flex align-items-center justify-content-center mb-3" 
                         style="width: 150px; height: 150px;">
                        <i class="fas fa-user fa-4x text-white"></i>
                    </div>
                @endif
                
                <h4 class="mb-1">{{ $scholar->name }}</h4>
                
                @if($scholar->nationality)
                    <p class="text-muted mb-2">
                        <i class="fas fa-flag me-1"></i>
                        {{ $scholar->nationality }}
                    </p>
                @endif
                
                @if($scholar->birth_year || $scholar->death_year)
                    <p class="text-muted mb-3">
                        <i class="fas fa-calendar me-1"></i>
                        @if($scholar->birth_year && $scholar->death_year)
                            {{ $scholar->birth_year }} - {{ $scholar->death_year }} هـ
                        @elseif($scholar->birth_year)
                            مولود {{ $scholar->birth_year }} هـ
                        @else
                            متوفى {{ $scholar->death_year }} هـ
                        @endif
                    </p>
                @endif
                
                <div class="d-flex justify-content-center gap-2">
                    @if($scholar->is_active)
                        <span class="badge bg-success">نشط</span>
                    @else
                        <span class="badge bg-secondary">غير نشط</span>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Statistics -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    الإحصائيات
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="mb-3">
                            <div class="h3 text-primary mb-0">{{ $scholar->courses_count ?? 0 }}</div>
                            <small class="text-muted">الدورات</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-3">
                            <div class="h3 text-success mb-0">{{ $scholar->lessons_count ?? 0 }}</div>
                            <small class="text-muted">الدروس</small>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="text-center">
                    <small class="text-muted d-block">تاريخ الإضافة</small>
                    <strong>{{ $scholar->created_at->format('Y/m/d H:i') }}</strong>
                </div>
                
                @if($scholar->updated_at != $scholar->created_at)
                    <div class="text-center mt-2">
                        <small class="text-muted d-block">آخر تعديل</small>
                        <strong>{{ $scholar->updated_at->format('Y/m/d H:i') }}</strong>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- External Links -->
        @if($scholar->website || $scholar->social_links)
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-link me-2"></i>
                        الروابط الخارجية
                    </h5>
                </div>
                <div class="card-body">
                    @if($scholar->website)
                        <div class="mb-2">
                            <a href="{{ $scholar->website }}" 
                               target="_blank" 
                               class="btn btn-outline-primary btn-sm w-100">
                                <i class="fas fa-globe me-2"></i>
                                الموقع الإلكتروني
                            </a>
                        </div>
                    @endif
                    
                    @if($scholar->social_links)
                        <div class="mb-0">
                            <label class="form-label small text-muted">الروابط الاجتماعية:</label>
                            <p class="small">{{ $scholar->social_links }}</p>
                        </div>
                    @endif
                </div>
            </div>
        @endif
    </div>
    
    <div class="col-lg-8">
        <!-- Biography -->
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-edit me-2"></i>
                    السيرة الذاتية
                </h5>
            </div>
            <div class="card-body">
                @if($scholar->bio)
                    <div class="mb-3">
                        <h6 class="text-muted">نبذة مختصرة:</h6>
                        <p class="lead">{{ $scholar->bio }}</p>
                    </div>
                @endif
                
                @if($scholar->detailed_bio)
                    <div>
                        <h6 class="text-muted">السيرة التفصيلية:</h6>
                        <div class="text-justify">
                            {!! nl2br(e($scholar->detailed_bio)) !!}
                        </div>
                    </div>
                @endif
                
                @if(!$scholar->bio && !$scholar->detailed_bio)
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-info-circle fa-2x mb-2"></i>
                        <p>لم يتم إضافة سيرة ذاتية لهذا العالم بعد</p>
                        <a href="{{ route('admin.scholars.edit', $scholar) }}" class="btn btn-warning btn-sm">
                            <i class="fas fa-edit me-1"></i>
                            إضافة السيرة
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Courses -->
        <div class="card mt-3">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-book me-2"></i>
                    الدورات ({{ $scholar->courses_count ?? 0 }})
                </h5>
                @if($scholar->courses_count > 0)
                    <a href="{{ route('admin.courses.index', ['scholar' => $scholar->id]) }}" 
                       class="btn btn-outline-primary btn-sm">
                        <i class="fas fa-eye me-1"></i>
                        عرض الكل
                    </a>
                @endif
            </div>
            <div class="card-body">
                @if($scholar->courses && $scholar->courses->count() > 0)
                    <div class="row">
                        @foreach($scholar->courses->take(6) as $course)
                            <div class="col-md-6 col-lg-4 mb-3">
                                <div class="card h-100">
                                    @if($course->image)
                                        <img src="{{ $course->image_url }}" 
                                             class="card-img-top" 
                                             alt="{{ $course->title }}"
                                             style="height: 120px; object-fit: cover;">
                                    @endif
                                    <div class="card-body p-2">
                                        <h6 class="card-title small mb-1">{{ $course->title }}</h6>
                                        <p class="card-text small text-muted mb-2">
                                            {{ Str::limit($course->description, 60) }}
                                        </p>
                                        <div class="d-flex justify-content-between align-items-center">
                                            <small class="text-muted">
                                                <i class="fas fa-play-circle me-1"></i>
                                                {{ $course->lessons_count ?? 0 }} دروس
                                            </small>
                                            @if($course->is_active)
                                                <span class="badge bg-success">نشط</span>
                                            @else
                                                <span class="badge bg-secondary">غير نشط</span>
                                            @endif
                                        </div>
                                        <div class="mt-2">
                                            <a href="{{ route('admin.courses.show', $course) }}" 
                                               class="btn btn-outline-primary btn-sm">
                                                <i class="fas fa-eye me-1"></i>
                                                عرض
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    
                    @if($scholar->courses_count > 6)
                        <div class="text-center mt-3">
                            <a href="{{ route('admin.courses.index', ['scholar' => $scholar->id]) }}" 
                               class="btn btn-primary">
                                <i class="fas fa-eye me-2"></i>
                                عرض جميع الدورات ({{ $scholar->courses_count }})
                            </a>
                        </div>
                    @endif
                @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-book fa-2x mb-2"></i>
                        <p>لا توجد دورات لهذا العالم بعد</p>
                        <a href="{{ route('admin.courses.create', ['scholar' => $scholar->id]) }}" 
                           class="btn btn-success btn-sm">
                            <i class="fas fa-plus me-1"></i>
                            إضافة أول دورة
                        </a>
                    </div>
                @endif
            </div>
        </div>
        
        <!-- Quick Actions -->
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    إجراءات سريعة
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6 mb-2">
                        <a href="{{ route('admin.courses.create', ['scholar' => $scholar->id]) }}" 
                           class="btn btn-success w-100">
                            <i class="fas fa-plus me-2"></i>
                            إضافة دورة جديدة
                        </a>
                    </div>
                    <div class="col-md-6 mb-2">
                        <a href="{{ route('admin.scholars.duplicate', $scholar) }}" 
                           class="btn btn-info w-100">
                            <i class="fas fa-copy me-2"></i>
                            نسخ العالم
                        </a>
                    </div>
                    <div class="col-md-6 mb-2">
                        <a href="{{ route('scholars.show', $scholar) }}" 
                           target="_blank"
                           class="btn btn-outline-primary w-100">
                            <i class="fas fa-external-link-alt me-2"></i>
                            عرض في الموقع
                        </a>
                    </div>
                    <div class="col-md-6 mb-2">
                        @if($scholar->courses_count == 0)
                            <button type="button" 
                                    class="btn btn-outline-danger w-100"
                                    onclick="deleteScholar()">
                                <i class="fas fa-trash me-2"></i>
                                حذف العالم
                            </button>
                        @else
                            <button type="button" 
                                    class="btn btn-outline-secondary w-100"
                                    disabled
                                    title="لا يمكن حذف العالم لوجود دورات مرتبطة به">
                                <i class="fas fa-ban me-2"></i>
                                لا يمكن الحذف
                            </button>
                        @endif
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
                <p>هل أنت متأكد من حذف العالم <strong>{{ $scholar->name }}</strong>؟</p>
                <p class="text-danger small">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    لا يمكن التراجع عن هذا الإجراء وستفقد جميع المعلومات نهائياً
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <form action="{{ route('admin.scholars.destroy', $scholar) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">حذف نهائياً</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function toggleStatus(id, status) {
    if (confirm('هل تريد تغيير حالة هذا العالم؟')) {
        fetch(`/admin/scholars/${id}/toggle-status`, {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({ is_active: status })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            } else {
                alert('حدث خطأ أثناء تغيير الحالة');
            }
        });
    }
}

function deleteScholar() {
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
