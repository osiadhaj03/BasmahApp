@extends('layouts.admin')

@section('title', 'لوحة التحكم')

@section('content')

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">
        <i class="fas fa-tachometer-alt text-primary me-2"></i>
        لوحة التحكم - نظام الدورات الشرعية
    </h2>
    <div class="text-muted">
        <i class="fas fa-calendar me-1"></i>
        {{ now()->format('Y/m/d - H:i') }}
    </div>
</div>

<!-- Main Statistics Cards -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card stats-card text-center">
            <div class="card-body">
                <i class="fas fa-user-graduate fa-3x mb-3"></i>
                <div class="stats-number">{{ $stats['scholars']['total'] ?? 0 }}</div>
                <div class="mb-2">إجمالي العلماء</div>
                <small class="text-light">
                    نشط: {{ $stats['scholars']['active'] ?? 0 }} | 
                    غير نشط: {{ $stats['scholars']['inactive'] ?? 0 }}
                </small>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('admin.scholars.index') }}" class="btn btn-light btn-sm w-100">
                    <i class="fas fa-eye me-1"></i>
                    عرض الكل
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-success text-white text-center">
            <div class="card-body">
                <i class="fas fa-tags fa-3x mb-3"></i>
                <div class="stats-number">{{ $stats['categories']['total'] ?? 0 }}</div>
                <div class="mb-2">الأقسام</div>
                <small>
                    نشط: {{ $stats['categories']['active'] ?? 0 }} | 
                    غير نشط: {{ $stats['categories']['inactive'] ?? 0 }}
                </small>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('admin.categories.index') }}" class="btn btn-light btn-sm w-100">
                    <i class="fas fa-eye me-1"></i>
                    عرض الكل
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-info text-white text-center">
            <div class="card-body">
                <i class="fas fa-book fa-3x mb-3"></i>
                <div class="stats-number">{{ $stats['courses']['total'] ?? 0 }}</div>
                <div class="mb-2">الدورات</div>
                <small>
                    نشط: {{ $stats['courses']['active'] ?? 0 }} | 
                    غير نشط: {{ $stats['courses']['inactive'] ?? 0 }}
                </small>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('admin.courses.index') }}" class="btn btn-light btn-sm w-100">
                    <i class="fas fa-eye me-1"></i>
                    عرض الكل
                </a>
            </div>
        </div>
    </div>
    
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-warning text-white text-center">
            <div class="card-body">
                <i class="fas fa-play-circle fa-3x mb-3"></i>
                <div class="stats-number">{{ $stats['lessons']['total'] ?? 0 }}</div>
                <div class="mb-2">الدروس</div>
                <small>
                    نشط: {{ $stats['lessons']['active'] ?? 0 }} | 
                    غير نشط: {{ $stats['lessons']['inactive'] ?? 0 }}
                </small>
            </div>
            <div class="card-footer bg-transparent">
                <a href="{{ route('admin.lessons.index') }}" class="btn btn-light btn-sm w-100">
                    <i class="fas fa-eye me-1"></i>
                    عرض الكل
                </a>
            </div>
        </div>
    </div>
</div>

<!-- Quick Actions -->
<div class="row mb-4">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt me-2"></i>
                    إجراءات سريعة
                </h5>
            </div>
            <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-white-50 small">الطلاب</div>
                            <div class="h2 mb-0">{{ $data['totalStudents'] ?? 0 }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-graduate fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-white-50 small">الدروس</div>
                            <div class="h2 mb-0">{{ $data['totalLessons'] ?? 0 }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-book fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @elseif(auth()->user()->role === 'teacher')
        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card stats-card">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-white-50 small">دروسي</div>
                            <div class="h2 mb-0 text-white">{{ $data['myLessons'] ?? 0 }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-book fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-white-50 small">طلابي</div>
                            <div class="h2 mb-0">{{ $data['myStudents'] ?? 0 }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-user-graduate fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-white-50 small">حضور اليوم</div>
                            <div class="h2 mb-0">{{ $data['todayAttendances'] ?? 0 }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-calendar-day fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <div class="col-xl-3 col-md-6 mb-4">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-white-50 small">إجمالي الحضور</div>
                            <div class="h2 mb-0">{{ $data['totalAttendances'] ?? 0 }}</div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-clipboard-check fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>

<!-- Content Management Statistics (Admin Only) -->
@if(auth()->user()->role === 'admin')
<div class="row mb-4">
    <div class="col-12">
        <h5 class="text-muted mb-3">
            <i class="fas fa-folder-open me-2"></i>إحصائيات إدارة المحتوى
        </h5>
    </div>
    
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card bg-purple text-white" style="background: linear-gradient(135deg, #6f42c1, #5a32a3);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-50 small">الكتب</div>
                        <div class="h4 mb-0">{{ $data['totalBooks'] ?? 0 }}</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-book fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card bg-secondary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-50 small">كتب منشورة</div>
                        <div class="h4 mb-0">{{ $data['publishedBooks'] ?? 0 }}</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card text-white" style="background: linear-gradient(135deg, #e83e8c, #d91a72);">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-50 small">المقالات</div>
                        <div class="h4 mb-0">{{ $data['totalArticles'] ?? 0 }}</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-newspaper fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-50 small">مقالات منشورة</div>
                        <div class="h4 mb-0">{{ $data['publishedArticles'] ?? 0 }}</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-globe fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-50 small">الأخبار</div>
                        <div class="h4 mb-0">{{ $data['totalNews'] ?? 0 }}</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-bullhorn fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
    
    <div class="col-xl-2 col-md-4 mb-4">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-50 small">أخبار عاجلة</div>
                        <div class="h4 mb-0">{{ $data['urgentNews'] ?? 0 }}</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-exclamation-triangle fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endif

<!-- Quick Actions -->
<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tachometer-alt me-2"></i>
                    الإجراءات السريعة
                </h5>
            </div>
            <div class="card-body">                <div class="row">
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('admin.scholars.create') }}" class="btn btn-success w-100 p-3">
                            <i class="fas fa-user-plus fa-2x d-block mb-2"></i>
                            إضافة عالم جديد
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('admin.categories.create') }}" class="btn btn-primary w-100 p-3">
                            <i class="fas fa-plus fa-2x d-block mb-2"></i>
                            إضافة قسم جديد
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('admin.courses.create') }}" class="btn btn-info w-100 p-3">
                            <i class="fas fa-book-open fa-2x d-block mb-2"></i>
                            إضافة دورة جديدة
                        </a>
                    </div>
                    <div class="col-lg-3 col-md-6 mb-3">
                        <a href="{{ route('admin.lessons.create') }}" class="btn btn-warning w-100 p-3">
                            <i class="fas fa-video fa-2x d-block mb-2"></i>
                            إضافة درس جديد
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="row">
    <!-- Recent Scholars -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-graduate me-2"></i>
                    أحدث العلماء
                </h5>
                <a href="{{ route('admin.scholars.index') }}" class="btn btn-outline-primary btn-sm">
                    عرض الكل
                </a>
            </div>
            <div class="card-body">
                @if(isset($recentScholars) && $recentScholars->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentScholars as $scholar)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div class="d-flex align-items-center">
                                    @if($scholar->image)
                                        <img src="{{ $scholar->image_url }}" 
                                             alt="{{ $scholar->name }}" 
                                             class="rounded-circle me-3" 
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded-circle d-flex align-items-center justify-content-center me-3" 
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-user text-white"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ $scholar->name }}</h6>
                                        <small class="text-muted">{{ $scholar->courses_count ?? 0 }} دورة</small>
                                    </div>
                                </div>
                                <div>
                                    @if($scholar->is_active)
                                        <span class="badge bg-success">نشط</span>
                                    @else
                                        <span class="badge bg-secondary">غير نشط</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-user-graduate fa-2x mb-2"></i>
                        <p>لا توجد علماء حتى الآن</p>
                        <a href="{{ route('admin.scholars.create') }}" class="btn btn-success btn-sm">
                            إضافة أول عالم
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
    
    <!-- Recent Courses -->
    <div class="col-lg-6 mb-4">
        <div class="card">
            <div class="card-header d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-book me-2"></i>
                    أحدث الدورات
                </h5>
                <a href="{{ route('admin.courses.index') }}" class="btn btn-outline-primary btn-sm">
                    عرض الكل
                </a>
            </div>
            <div class="card-body">
                @if(isset($recentCourses) && $recentCourses->count() > 0)
                    <div class="list-group list-group-flush">
                        @foreach($recentCourses as $course)
                            <div class="list-group-item d-flex justify-content-between align-items-center px-0">
                                <div class="d-flex align-items-center">
                                    @if($course->image)
                                        <img src="{{ $course->image_url }}" 
                                             alt="{{ $course->title }}" 
                                             class="rounded me-3" 
                                             style="width: 40px; height: 40px; object-fit: cover;">
                                    @else
                                        <div class="bg-secondary rounded d-flex align-items-center justify-content-center me-3" 
                                             style="width: 40px; height: 40px;">
                                            <i class="fas fa-book text-white"></i>
                                        </div>
                                    @endif
                                    <div>
                                        <h6 class="mb-0">{{ $course->title }}</h6>
                                        <small class="text-muted">
                                            {{ $course->scholar->name ?? 'غير محدد' }} - 
                                            {{ $course->lessons_count ?? 0 }} دروس
                                        </small>
                                    </div>
                                </div>
                                <div>
                                    @if($course->is_active)
                                        <span class="badge bg-success">نشط</span>
                                    @else
                                        <span class="badge bg-secondary">غير نشط</span>
                                    @endif
                                </div>
                            </div>
                        @endforeach
                    </div>
                @else
                    <div class="text-center text-muted py-4">
                        <i class="fas fa-book fa-2x mb-2"></i>
                        <p>لا توجد دورات حتى الآن</p>
                        <a href="{{ route('admin.courses.create') }}" class="btn btn-info btn-sm">
                            إضافة أول دورة
                        </a>
                    </div>
                @endif
            </div>
        </div>
    </div>
</div>
                        <a href="{{ route('admin.lessons.index') }}" class="btn btn-success btn-lg w-100">
                            <i class="fas fa-book me-2"></i>
                            إدارة الدروس
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.attendances.index') }}" class="btn btn-info btn-lg w-100">
                            <i class="fas fa-clipboard-check me-2"></i>
                            إدارة الحضور
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.users.create') }}" class="btn btn-warning btn-lg w-100">
                            <i class="fas fa-user-plus me-2"></i>
                            إضافة مستخدم
                        </a>
                    </div>
                    <div class="col-md-6 mb-3">
                        <a href="{{ route('admin.lessons.create') }}" class="btn btn-secondary btn-lg w-100">
                            <i class="fas fa-plus me-2"></i>
                            إضافة درس جديد
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle me-2"></i>
                    معلومات النظام
                </h5>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center mb-3">
                    <div class="flex-shrink-0">
                        <i class="fas fa-user-circle fa-2x text-primary"></i>
                    </div>
                    <div class="flex-grow-1 ms-3">
                        <h6 class="mb-0">{{ auth()->user()->name }}</h6>
                        <small class="text-muted">
                            {{ auth()->user()->role === 'admin' ? 'مدير النظام' : 'معلم' }}
                        </small>
                    </div>
                </div>
                
                <hr>
                
                <div class="text-center">
                    <h6 class="text-primary">أنوار العلوم</h6>
                    <small class="text-muted">نظام إدارة الحضور الذكي</small>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
