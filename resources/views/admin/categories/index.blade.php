@extends('layouts.admin')

@section('title', 'إدارة الأقسام')

@section('content')
@php
    $breadcrumb = [
        ['title' => 'الرئيسية', 'url' => route('admin.dashboard')],
        ['title' => 'الأقسام', 'url' => '']
    ];
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">
        <i class="fas fa-tags text-primary me-2"></i>
        إدارة الأقسام
    </h2>
    <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>
        إضافة قسم جديد
    </a>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.categories.index') }}">
            <div class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">البحث</label>
                    <input type="text" name="search" class="form-control" 
                           placeholder="البحث في الاسم أو الوصف..." 
                           value="{{ request('search') }}">
                </div>
                <div class="col-md-2">
                    <label class="form-label">الحالة</label>
                    <select name="status" class="form-select">
                        <option value="">جميع الحالات</option>
                        <option value="1" {{ request('status') == '1' ? 'selected' : '' }}>نشط</option>
                        <option value="0" {{ request('status') == '0' ? 'selected' : '' }}>غير نشط</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">الترتيب</label>
                    <select name="sort" class="form-select">
                        <option value="sort_order" {{ request('sort') == 'sort_order' ? 'selected' : '' }}>الترتيب</option>
                        <option value="name" {{ request('sort') == 'name' ? 'selected' : '' }}>الاسم</option>
                        <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>تاريخ الإضافة</option>
                        <option value="courses_count" {{ request('sort') == 'courses_count' ? 'selected' : '' }}>عدد الدورات</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">الاتجاه</label>
                    <select name="direction" class="form-select">
                        <option value="asc" {{ request('direction') == 'asc' ? 'selected' : '' }}>تصاعدي</option>
                        <option value="desc" {{ request('direction') == 'desc' ? 'selected' : '' }}>تنازلي</option>
                    </select>
                </div>
                <div class="col-md-2 d-flex align-items-end">
                    <button type="submit" class="btn btn-primary me-2">
                        <i class="fas fa-search"></i>
                    </button>
                    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
                        <i class="fas fa-times"></i>
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<!-- Statistics Cards -->
<div class="row mb-4">
    <div class="col-md-3">
        <div class="card stats-card text-center">
            <div class="card-body">
                <i class="fas fa-tags fa-2x mb-2"></i>
                <div class="stats-number">{{ $stats['total'] ?? 0 }}</div>
                <div>إجمالي الأقسام</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-success text-white text-center">
            <div class="card-body">
                <i class="fas fa-check-circle fa-2x mb-2"></i>
                <div class="stats-number">{{ $stats['active'] ?? 0 }}</div>
                <div>نشط</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-warning text-white text-center">
            <div class="card-body">
                <i class="fas fa-pause-circle fa-2x mb-2"></i>
                <div class="stats-number">{{ $stats['inactive'] ?? 0 }}</div>
                <div>غير نشط</div>
            </div>
        </div>
    </div>
    <div class="col-md-3">
        <div class="card bg-info text-white text-center">
            <div class="card-body">
                <i class="fas fa-book fa-2x mb-2"></i>
                <div class="stats-number">{{ $stats['with_courses'] ?? 0 }}</div>
                <div>لديها دورات</div>
            </div>
        </div>
    </div>
</div>

<!-- Categories Table -->
<div class="card">
    <div class="card-body">
        @if($categories->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>الأيقونة</th>
                            <th>الاسم</th>
                            <th>الوصف</th>
                            <th>عدد الدورات</th>
                            <th>الترتيب</th>
                            <th>الحالة</th>
                            <th>تاريخ الإضافة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody id="categoriesTable">
                        @foreach($categories as $category)
                            <tr data-id="{{ $category->id }}">
                                <td>
                                    @if($category->icon)
                                        <i class="{{ $category->icon }} fa-lg" 
                                           style="color: {{ $category->color ?? '#6c757d' }};"></i>
                                    @else
                                        <i class="fas fa-tag fa-lg text-muted"></i>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $category->name }}</strong>
                                    @if($category->slug)
                                        <br><small class="text-muted">{{ $category->slug }}</small>
                                    @endif
                                </td>
                                <td>
                                    <span class="text-muted">
                                        {{ Str::limit($category->description, 50) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $category->courses_count ?? 0 }}
                                    </span>
                                </td>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <span class="me-2">{{ $category->sort_order ?? 0 }}</span>
                                        <div class="btn-group btn-group-sm">
                                            <button type="button" 
                                                    class="btn btn-outline-primary btn-sm"
                                                    onclick="moveCategory({{ $category->id }}, 'up')"
                                                    title="تحريك لأعلى">
                                                <i class="fas fa-arrow-up"></i>
                                            </button>
                                            <button type="button" 
                                                    class="btn btn-outline-primary btn-sm"
                                                    onclick="moveCategory({{ $category->id }}, 'down')"
                                                    title="تحريك لأسفل">
                                                <i class="fas fa-arrow-down"></i>
                                            </button>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    @if($category->is_active)
                                        <span class="badge bg-success">نشط</span>
                                    @else
                                        <span class="badge bg-secondary">غير نشط</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $category->created_at->format('Y/m/d') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.categories.show', $category) }}" 
                                           class="btn btn-outline-info"
                                           title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.categories.edit', $category) }}" 
                                           class="btn btn-outline-warning"
                                           title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-{{ $category->is_active ? 'secondary' : 'success' }}"
                                                onclick="toggleStatus({{ $category->id }}, {{ $category->is_active ? 'false' : 'true' }})"
                                                title="{{ $category->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}">
                                            <i class="fas fa-{{ $category->is_active ? 'pause' : 'play' }}"></i>
                                        </button>
                                        @if($category->courses_count == 0)
                                            <button type="button" 
                                                    class="btn btn-outline-danger"
                                                    onclick="deleteCategory({{ $category->id }})"
                                                    title="حذف">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        @endif
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <!-- Pagination -->
            <div class="d-flex justify-content-center mt-4">
                {{ $categories->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-tags fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">لا توجد أقسام</h5>
                <p class="text-muted">لم يتم العثور على أي أقسام بالمعايير المحددة</p>
                <a href="{{ route('admin.categories.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>
                    إضافة أول قسم
                </a>
            </div>
        @endif
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
                <p>هل أنت متأكد من حذف هذا القسم؟</p>
                <p class="text-danger small">
                    <i class="fas fa-exclamation-triangle me-1"></i>
                    لا يمكن التراجع عن هذا الإجراء
                </p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">حذف</button>
                </form>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
function toggleStatus(id, status) {
    if (confirm('هل تريد تغيير حالة هذا القسم؟')) {
        fetch(`/admin/categories/${id}/toggle-status`, {
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

function moveCategory(id, direction) {
    fetch(`/admin/categories/${id}/move`, {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
        },
        body: JSON.stringify({ direction: direction })
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        } else {
            alert('حدث خطأ أثناء تغيير الترتيب');
        }
    });
}

function deleteCategory(id) {
    document.getElementById('deleteForm').action = `/admin/categories/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
