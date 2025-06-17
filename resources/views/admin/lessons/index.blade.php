@extends('layouts.admin')

@section('title', 'إدارة الدروس')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">إدارة الدروس</h1>
    <a href="{{ route('admin.lessons.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        إضافة درس جديد
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($lessons->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>المادة</th>
                            <th>المعلم</th>
                            <th>يوم الأسبوع</th>
                            <th>الوقت</th>
                            <th>عدد الطلاب</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($lessons as $lesson)
                            <tr>
                                <td>
                                    <strong>{{ $lesson->subject }}</strong>
                                </td>
                                <td>
                                    <i class="fas fa-user me-1"></i>
                                    {{ $lesson->teacher->name }}
                                </td>
                                <td>
                                    <span class="badge bg-secondary">
                                        @switch($lesson->day_of_week)
                                            @case('sunday') الأحد @break
                                            @case('monday') الإثنين @break
                                            @case('tuesday') الثلاثاء @break
                                            @case('wednesday') الأربعاء @break
                                            @case('thursday') الخميس @break
                                            @case('friday') الجمعة @break
                                            @case('saturday') السبت @break
                                        @endswitch
                                    </span>
                                </td>
                                <td>
                                    <i class="fas fa-clock me-1"></i>
                                    {{ \Carbon\Carbon::parse($lesson->start_time)->format('H:i') }} - 
                                    {{ \Carbon\Carbon::parse($lesson->end_time)->format('H:i') }}
                                </td>
                                <td>
                                    <span class="badge bg-info">
                                        {{ $lesson->students_count ?? $lesson->students->count() }} طالب
                                    </span>
                                </td>
                <td>
                    <div class="btn-group btn-group-sm" role="group">
                        <a href="{{ route('admin.lessons.qr.generate', $lesson) }}" 
                           class="btn btn-outline-success" title="QR Code للحضور">
                            <i class="fas fa-qrcode"></i>
                        </a>
                        <a href="{{ route('admin.lessons.show', $lesson) }}" 
                           class="btn btn-outline-info" title="عرض">
                            <i class="fas fa-eye"></i>
                        </a>
                        <a href="{{ route('admin.lessons.edit', $lesson) }}" 
                           class="btn btn-outline-warning" title="تعديل">
                            <i class="fas fa-edit"></i>
                        </a>
                        <form method="POST" 
                              action="{{ route('admin.lessons.destroy', $lesson) }}" 
                              class="d-inline"
                              onsubmit="return confirm('هل أنت متأكد من حذف هذا الدرس؟')">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-outline-danger" title="حذف">
                                <i class="fas fa-trash"></i>
                            </button>
                        </form>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>

            <div class="d-flex justify-content-center mt-4">
                {{ $lessons->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-book fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">لا توجد دروس</h5>
                <p class="text-muted">ابدأ بإضافة درس جديد</p>
                <a href="{{ route('admin.lessons.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    إضافة درس جديد
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
