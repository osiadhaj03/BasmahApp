

<?php $__env->startSection('title', 'عرض QR Code - ' . $lesson->name); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-qrcode me-2"></i>
                        QR Code للحضور - <?php echo e($lesson->name); ?>

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
                                        <span><?php echo e($lesson->name); ?></span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between">
                                        <strong>المادة:</strong>
                                        <span><?php echo e($lesson->subject); ?></span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between">
                                        <strong>المعلم:</strong>
                                        <span><?php echo e($lesson->teacher->name); ?></span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between">
                                        <strong>اليوم:</strong>
                                        <span>
                                            <?php switch($lesson->day_of_week):
                                                case ('sunday'): ?> الأحد <?php break; ?>
                                                <?php case ('monday'): ?> الاثنين <?php break; ?>
                                                <?php case ('tuesday'): ?> الثلاثاء <?php break; ?>
                                                <?php case ('wednesday'): ?> الأربعاء <?php break; ?>
                                                <?php case ('thursday'): ?> الخميس <?php break; ?>
                                                <?php case ('friday'): ?> الجمعة <?php break; ?>
                                                <?php case ('saturday'): ?> السبت <?php break; ?>
                                            <?php endswitch; ?>
                                        </span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between">
                                        <strong>الوقت:</strong>
                                        <span><?php echo e($lesson->start_time->format('H:i')); ?> - <?php echo e($lesson->end_time->format('H:i')); ?></span>
                                    </div>
                                    <div class="list-group-item d-flex justify-content-between">
                                        <strong>عدد الطلاب:</strong>
                                        <span><?php echo e($lesson->students()->count()); ?></span>
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
                                
                                <div class="qr-status mb-3">
                                    <div id="token-status" class="alert alert-info">
                                        <i class="fas fa-clock me-2"></i>
                                        <span id="status-text">جاري تحميل معلومات QR...</span>
                                    </div>
                                    <div id="timer-display" class="text-center mb-2">
                                        <span class="badge bg-primary fs-6" id="countdown-timer">--:--</span>
                                    </div>
                                </div>
                                
                                <div class="qr-code-display bg-light p-4 rounded" id="qr-container">
                                    <div class="text-center">
                                        <div class="spinner-border" role="status">
                                            <span class="visually-hidden">جاري التحميل...</span>
                                        </div>
                                        <p class="mt-2">جاري توليد QR Code...</p>
                                    </div>
                                </div>
                                
                                <p class="text-muted mt-3">
                                    <i class="fas fa-info-circle me-1"></i>
                                    <strong>QR Code صالح لمدة 15 دقيقة فقط</strong><br>
                                    <small>اطلب من الطلاب مسح الكود لتسجيل الحضور</small>
                                </p>
                                
                                <div class="mt-4">
                                    <button class="btn btn-success btn-lg" onclick="generateNewQR()" id="refresh-btn">
                                        <i class="fas fa-sync-alt me-2"></i>
                                        توليد QR جديد
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
                                                <h4 id="total-students"><?php echo e($lesson->students()->count()); ?></h4>
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
                        <a href="<?php echo e(route('admin.lessons.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-arrow-right me-2"></i>
                            العودة للدروس
                        </a>                        <div>
                            <a href="<?php echo e(route('admin.lessons.show', $lesson)); ?>" class="btn btn-info">
                                <i class="fas fa-eye me-2"></i>
                                عرض الدرس
                            </a>
                            <a href="<?php echo e(route('admin.attendances.index')); ?>?lesson_id=<?php echo e($lesson->id); ?>" class="btn btn-primary">
                                <i class="fas fa-list me-2"></i>
                                مراجعة الحضور
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
let currentTimer;
let tokenData = null;

// Initialize QR display
document.addEventListener('DOMContentLoaded', function() {
    checkQRStatus();
    // تحديث حالة QR كل 10 ثوانٍ
    setInterval(checkQRStatus, 10000);
});

function checkQRStatus() {
    fetch('<?php echo e(route("admin.lessons.qr.info", $lesson)); ?>')
        .then(response => response.json())
        .then(data => {
            tokenData = data;
            updateQRDisplay(data);
            if (data.has_valid_token && data.token_remaining_minutes > 0) {
                loadQRImage();
                startCountdown(data.token_remaining_minutes);
            } else {
                showExpiredQR();
            }
        })
        .catch(error => {
            console.error('Error:', error);
            showErrorQR();
        });
}

function updateQRDisplay(data) {
    const statusEl = document.getElementById('status-text');
    const timerEl = document.getElementById('countdown-timer');
    const alertEl = document.getElementById('token-status');
    
    if (data.has_valid_token) {
        statusEl.textContent = 'QR Code نشط - صالح للاستخدام';
        alertEl.className = 'alert alert-success';
        timerEl.textContent = formatTime(data.token_remaining_minutes);
    } else {
        statusEl.textContent = 'QR Code منتهي الصلاحية - يحتاج توليد جديد';
        alertEl.className = 'alert alert-warning';
        timerEl.textContent = '00:00';
    }
}

function loadQRImage() {
    const container = document.getElementById('qr-container');
    if (tokenData && tokenData.qr_url) {
        container.innerHTML = `
            <img src="${tokenData.qr_url}?t=${Date.now()}" 
                 alt="QR Code" 
                 class="img-fluid" 
                 style="max-width: 300px;"
                 onerror="showErrorQR()">
        `;
    }
}

function showExpiredQR() {
    const container = document.getElementById('qr-container');
    container.innerHTML = `
        <div class="text-center p-4">
            <i class="fas fa-clock text-warning" style="font-size: 4rem;"></i>
            <h5 class="mt-3">QR Code منتهي الصلاحية</h5>
            <p class="text-muted">اضغط على "توليد QR جديد" للبدء</p>
        </div>
    `;
    clearTimeout(currentTimer);
}

function showErrorQR() {
    const container = document.getElementById('qr-container');
    container.innerHTML = `
        <div class="text-center p-4">
            <i class="fas fa-exclamation-triangle text-danger" style="font-size: 4rem;"></i>
            <h5 class="mt-3">خطأ في تحميل QR Code</h5>
            <p class="text-muted">يرجى المحاولة مرة أخرى</p>
        </div>
    `;
}

function generateNewQR() {
    const refreshBtn = document.getElementById('refresh-btn');
    refreshBtn.disabled = true;
    refreshBtn.innerHTML = '<i class="fas fa-spinner fa-spin me-2"></i>جاري التوليد...';
    
    fetch('<?php echo e(route("admin.lessons.qr.refresh", $lesson)); ?>', {
        method: 'POST',
        headers: {
            'Content-Type': 'application/json',
            'X-CSRF-TOKEN': '<?php echo e(csrf_token()); ?>'
        }
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            // إعادة تحميل معلومات QR
            setTimeout(() => {
                checkQRStatus();
                refreshBtn.disabled = false;
                refreshBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i>توليد QR جديد';
            }, 1000);
        } else {
            alert('حدث خطأ في توليد QR جديد');
            refreshBtn.disabled = false;
            refreshBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i>توليد QR جديد';
        }
    })
    .catch(error => {
        console.error('Error:', error);
        alert('حدث خطأ في الاتصال');
        refreshBtn.disabled = false;
        refreshBtn.innerHTML = '<i class="fas fa-sync-alt me-2"></i>توليد QR جديد';
    });
}

function startCountdown(minutes) {
    clearTimeout(currentTimer);
    let totalSeconds = minutes * 60;
    
    function updateTimer() {
        const mins = Math.floor(totalSeconds / 60);
        const secs = totalSeconds % 60;
        document.getElementById('countdown-timer').textContent = 
            `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
        
        if (totalSeconds <= 0) {
            showExpiredQR();
            return;
        }
        
        totalSeconds--;
        currentTimer = setTimeout(updateTimer, 1000);
    }
    
    updateTimer();
}

function formatTime(minutes) {
    const mins = Math.floor(minutes);
    const secs = Math.round((minutes - mins) * 60);
    return `${mins.toString().padStart(2, '0')}:${secs.toString().padStart(2, '0')}`;
}

// Update attendance stats every 30 seconds
setInterval(function() {
    updateAttendanceStats();
}, 30000);

function updateAttendanceStats() {
    // يمكن إضافة تحديث إحصائيات الحضور هنا لاحقاً
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\abdul\OneDrive\Documents\BasmahApp\resources\views/admin/lessons/qr-display.blade.php ENDPATH**/ ?>