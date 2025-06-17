@extends('layouts.admin')

@section('title', 'عرض QR Code - ' . $lesson->name)

@section('content')
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-qrcode me-2"></i>
                        QR Code للحضور - {{ $lesson->name }}
                    </h5>
                </div>
                <div class="card-body text-center">
                    <div class="row">
                        <div class="col-md-6">
                            <div class="lesson-info mb-4">
                                <h6 class="text-muted">معلومات الدرس</h6>
                                <div class="list-group">
                                    <div class="list-group-item d-flex justify-content-between">
                                        <strong>اسم الدرس:</strong>
                                        <span>{{ $lesson->name }}</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between">
                                        <strong>المادة:</strong>
                                        <span>{{ $lesson->subject }}</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between">
                                        <strong>المعلم:</strong>
                                        <span>{{ $lesson->teacher->name }}</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between">
                                        <strong>اليوم:</strong>
                                        <span>
                                            @switch($lesson->day_of_week)
                                                @case('sunday') الأحد @break
                                                @case('monday') الاثنين @break
                                                @case('tuesday') الثلاثاء @break
                                                @case('wednesday') الأربعاء @break
                                                @case('thursday') الخميس @break
                                                @case('friday') الجمعة @break
                                                @case('saturday') السبت @break
                                            @endswitch
                                        </span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between">
                                        <strong>الوقت:</strong>
                                        <span>{{ $lesson->start_time->format('H:i') }} - {{ $lesson->end_time->format('H:i') }}</span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between">
                                        <strong>عدد الطلاب:</strong>
                                        <span>{{ $lesson->students()->count() }}</span>
                                    </div>
                                </div>
                            </div>
                            
                            <div class="attendance-info">
                                <h6 class="text-muted">معلومات الحضور</h6>
                                <div class="alert alert-info">
                                    <i class="fas fa-clock me-2"></i>
                                    <strong>نافذة الحضور:</strong> أول 15 دقيقة من بداية الدرس
                                </div>
                                <div class="alert alert-warning">
                                    <i class="fas fa-exclamation-triangle me-2"></i>
                                    يجب على الطلاب مسح QR Code خلال الـ 15 دقيقة الأولى فقط
                                </div>
                            </div>
                        </div>
                        
                        <div class="col-md-6">
                            <div class="qr-container">
                                <h6 class="text-muted mb-3">QR Code للحضور</h6>
                                <div class="qr-code-display bg-light p-4 rounded">
                                    {!! $qrCode !!}
                                </div>
                                <p class="text-muted mt-3">
                                    <i class="fas fa-info-circle me-1"></i>
                                    اطلب من الطلاب مسح هذا الكود لتسجيل الحضور
                                </p>
                                
                                <div class="mt-4">
                                    <a href="{{ route('admin.lessons.qr.display', $lesson) }}" 
                                       class="btn btn-success btn-lg" target="_blank">
                                        <i class="fas fa-expand me-2"></i>
                                        عرض في الشاشة الكاملة
                                    </a>
                                </div>
                                
                                <div class="mt-3">
                                    <button class="btn btn-primary" onclick="refreshQR()">
                                        <i class="fas fa-sync-alt me-2"></i>
                                        تجديد QR Code
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <div class="row mt-4">
                        <div class="col-12">
                            <div class="attendance-status">
                                <h6 class="text-muted">حالة الحضور اليوم</h6>
                                <div id="attendance-stats" class="row">
                                    <div class="col-md-3">
                                        <div class="card bg-success text-white">
                                            <div class="card-body text-center">
                                                <h4 id="present-count">0</h4>
                                                <small>حاضر</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-warning text-white">
                                            <div class="card-body text-center">
                                                <h4 id="late-count">0</h4>
                                                <small>متأخر</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-danger text-white">
                                            <div class="card-body text-center">
                                                <h4 id="absent-count">0</h4>
                                                <small>غائب</small>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-3">
                                        <div class="card bg-info text-white">
                                            <div class="card-body text-center">
                                                <h4 id="total-students">{{ $lesson->students()->count() }}</h4>
                                                <small>إجمالي الطلاب</small>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex justify-content-between">
                        <a href="{{ route('admin.lessons.index') }}" class="btn btn-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة للدروس
                        </a>
                        <div>
                            <a href="{{ route('admin.lessons.show', $lesson) }}" class="btn btn-info">
                                <i class="fas fa-eye me-2"></i>
                                عرض الدرس
                            </a>
                            <a href="{{ route('admin.attendances.create') }}?lesson_id={{ $lesson->id }}" class="btn btn-primary">
                                <i class="fas fa-plus me-2"></i>
                                تسجيل حضور يدوي
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
function refreshQR() {
    window.location.reload();
}

// Update attendance stats every 30 seconds
setInterval(function() {
    updateAttendanceStats();
}, 30000);

function updateAttendanceStats() {
    fetch('{{ route("admin.lessons.qr.info", $lesson) }}')
        .then(response => response.json())
        .then(data => {
            // Update stats here if we add this functionality
        })
        .catch(error => console.error('Error:', error));
}
</script>
@endsection
