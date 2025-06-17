@extends('layouts.admin')

@section('title', 'إدارة الحضور')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">إدارة الحضور</h1>
    <a href="{{ route('admin.attendances.create') }}" class="btn btn-primary">
        <i class="fas fa-plus me-2"></i>
        تسجيل حضور جديد
    </a>
</div>

<div class="card">
    <div class="card-body">
        @if($attendances->count() > 0)
            <div class="table-responsive">
                <table class="table table-hover">
                    <thead>
                        <tr>
                            <th>الطالب</th>
                            <th>المادة</th>
                            @if(auth()->user()->role === 'admin')
                                <th>المعلم</th>
                            @endif
                            <th>التاريخ</th>
                            <th>الحالة</th>
                            <th>الإجراءات</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($attendances as $attendance)
                            <tr>
                                <td>
                                    <i class="fas fa-user me-1"></i>
                                    {{ $attendance->student->name }}
                                </td>
                                <td>
                                    <strong>{{ $attendance->lesson->subject }}</strong>
                                </td>
                                @if(auth()->user()->role === 'admin')
                                    <td>
                                        <i class="fas fa-chalkboard-teacher me-1"></i>
                                        {{ $attendance->lesson->teacher->name }}
                                    </td>
                                @endif
                                <td>
                                    <i class="fas fa-calendar me-1"></i>
                                    {{ \Carbon\Carbon::parse($attendance->date)->format('Y/m/d') }}
                                </td>
                                <td>
                                    @switch($attendance->status)
                                        @case('present')
                                            <span class="badge bg-success">حاضر</span>
                                            @break
                                        @case('absent')
                                            <span class="badge bg-danger">غائب</span>
                                            @break
                                        @case('late')
                                            <span class="badge bg-warning">متأخر</span>
                                            @break
                                        @case('excused')
                                            <span class="badge bg-info">غياب بعذر</span>
                                            @break
                                    @endswitch
                                </td>
                                <td>
                                    <div class="btn-group btn-group-sm" role="group">
                                        <a href="{{ route('admin.attendances.show', $attendance) }}" 
                                           class="btn btn-outline-info" title="عرض">
                                            <i class="fas fa-eye"></i>
                                        </a>
                                        <a href="{{ route('admin.attendances.edit', $attendance) }}" 
                                           class="btn btn-outline-warning" title="تعديل">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <form method="POST" 
                                              action="{{ route('admin.attendances.destroy', $attendance) }}" 
                                              class="d-inline"
                                              onsubmit="return confirm('هل أنت متأكد من حذف هذا السجل؟')">
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
                {{ $attendances->links() }}
            </div>
        @else
            <div class="text-center py-5">
                <i class="fas fa-clipboard-check fa-3x text-muted mb-3"></i>
                <h5 class="text-muted">لا توجد سجلات حضور</h5>
                <p class="text-muted">ابدأ بتسجيل حضور الطلاب</p>
                <a href="{{ route('admin.attendances.create') }}" class="btn btn-primary">
                    <i class="fas fa-plus me-2"></i>
                    تسجيل حضور جديد
                </a>
            </div>
        @endif
    </div>
</div>
@endsection
