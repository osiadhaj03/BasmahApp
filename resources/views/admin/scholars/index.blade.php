@extends('layouts.admin')

@section('title', 'إدارة العلماء')

@section('content')
@php
    $breadcrumb = [
        ['title' => 'الرئيسية', 'url' => route('admin.dashboard')],
        ['title' => 'العلماء', 'url' => '']
    ];
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">
        <i class="fas fa-user-graduate text-primary me-2"></i>
        إدارة العلماء
    </h2>
    <a href="{{ route('admin.scholars.create') }}" class="btn btn-success">
        <i class="fas fa-plus me-2"></i>
        إضافة عالم جديد
    </a>
</div>

<!-- Search and Filter -->
<div class="card mb-4">
    <div class="card-body">
        <form method="GET" action="{{ route('admin.scholars.index') }}">
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
                    <a href="{{ route('admin.scholars.index') }}" class="btn btn-outline-secondary">
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
                <i class="fas fa-user-graduate fa-2x mb-2"></i>
                <div class="stats-number">{{ $stats['total'] ?? 0 }}</div>
                <div>إجمالي العلماء</div>
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
                <div>لديهم دورات</div>
            </div>
        </div>
    </div>
</div>

<!-- Scholars Table -->
<div class="card">
    <div class="card-body">
        @if($scholars->count() > 0)
            <div class="table-responsive">
                <table class="table table-striped table-hover">
                    <thead>
                        <tr>
                            <th>الصورة</th>
                            <th>الاسم</th>
                            <th>الوصف المختصر</th>
                            <th>عدد الدورات</th>
                            <th>الحالة</th>
                            <th>تاريخ الإضافة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($scholars as $scholar)
                            <tr>
                                <td>
                                    @if($scholar->image)
                                        <img src="{{ $scholar->image_url }}" 
                                             alt="{{ $scholar->name }}" 
                                             class="rounded-circle" 
                                             style="width: 50px; height: 50px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center" 
                                             style="width: 50px; height: 50px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    @endif
                                </td>
                                <td>
                                    <strong>{{ $scholar->name }}</strong>
                                </td>
                                <td>
                                    <span class="text-muted">
                                        {{ Str::limit($scholar->bio, 50) }}
                                    </span>
                                </td>
                                <td>
                                    <span class="badge bg-primary">
                                        {{ $scholar->courses_count ?? 0 }}
                                    </span>
                                </td>
                                <td>
                                    @if($scholar->is_active)
                                        <span class="badge bg-success">نشط</span>
                                    @else
                                        <span class="badge bg-secondary">غير نشط</span>
                                    @endif
                                </td>
                                <td>
                                    <small class="text-muted">
                                        {{ $scholar->created_at->format('Y/m/d') }}
                                    </small>
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.scholars.show', $scholar) }}" 
                                           class="btn btn-outline-info"
                                           title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.scholars.edit', $scholar) }}" 
                                           class="btn btn-outline-warning"
                                           title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <button type="button" 
                                                class="btn btn-outline-{{ $scholar->is_active ? 'secondary' : 'success' }}"
                                                onclick="toggleStatus({{ $scholar->id }}, {{ $scholar->is_active ? 'false' : 'true' }})"
                                                title="{{ $scholar->is_active ? 'إلغاء التفعيل' : 'تفعيل' }}">
                                            <i class="fas fa-{{ $scholar->is_active ? 'pause' : 'play' }}"></i>
                                        </button>
                                        @if($scholar->courses_count == 0)
                                            <button type="button" 
                                                    class="btn btn-outline-danger"
                                                    onclick="deleteScholar({{ $scholar->id }})"
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
                {{ $scholars->appends(request()->query())->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-user-graduate fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">لا توجد علماء</h5>
                <p class="text-muted">لم يتم العثور على أي علماء بالمعايير المحددة</p>
                <a href="{{ route('admin.scholars.create') }}" class="btn btn-success">
                    <i class="fas fa-plus me-2"></i>
                    إضافة أول عالم
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
                <p>هل أنت متأكد من حذف هذا العالم؟</p>
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

function deleteScholar(id) {
    document.getElementById('deleteForm').action = `/admin/scholars/${id}`;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}
</script>
@endpush
