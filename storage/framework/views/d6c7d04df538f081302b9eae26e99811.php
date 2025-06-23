<?php $__env->startSection('title', 'إدارة دروسي'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">إدارة دروسي</h1>
        <p class="text-muted mb-0">إدارة وتنظيم الدروس الخاصة بك</p>
    </div>
    <div>
        <a href="<?php echo e(route('teacher.lessons.create')); ?>" class="btn btn-success">
            <i class="fas fa-plus"></i> إضافة درس جديد
        </a>
        <a href="<?php echo e(route('teacher.dashboard')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> العودة للوحة التحكم
        </a>
    </div>
</div>

<!-- إحصائيات سريعة -->
<div class="row mb-4">
    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-75 small">إجمالي الدروس</div>
                        <div class="h3 mb-0"><?php echo e($stats['total_lessons']); ?></div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-book fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-75 small">الدروس النشطة</div>
                        <div class="h3 mb-0"><?php echo e($stats['active_lessons']); ?></div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-play-circle fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card bg-info text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-75 small">إجمالي الطلاب</div>
                        <div class="h3 mb-0"><?php echo e($stats['total_students']); ?></div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-user-graduate fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-xl-3 col-md-6 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-75 small">معدل الحضور</div>
                        <div class="h3 mb-0"><?php echo e($stats['avg_attendance']); ?>%</div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-chart-line fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- قائمة الدروس -->
<div class="card">
    <div class="card-header bg-light">
        <h5 class="card-title mb-0">
            <i class="fas fa-list"></i>
            قائمة دروسي (<?php echo e($lessons->total()); ?>)
        </h5>
    </div>
    <div class="card-body">
        <?php if($lessons->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover">                <thead>
                    <tr>
                        <th>المادة</th>
                        <th>اليوم والوقت</th>
                        <th class="text-center">الطلاب</th>
                        <th class="text-center">الحضور</th>
                        <th class="text-center">الحالة</th>
                        <th class="text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <?php
                        $attendanceCount = $lesson->attendances_count;
                        $presentCount = $lesson->attendances->where('status', 'present')->count();
                        $attendanceRate = $attendanceCount > 0 ? round(($presentCount / $attendanceCount) * 100, 1) : 0;
                    ?>
                    <tr>                        <td>
                            <div>
                                <strong><?php echo e($lesson->subject); ?></strong>
                                <?php if($lesson->description): ?>
                                    <br><small class="text-muted"><?php echo e(Str::limit($lesson->description, 50)); ?></small>
                                <?php endif; ?>
                            </div>
                        </td>                        <td>
                            <?php if($lesson->day_of_week && $lesson->start_time): ?>
                            <div>
                                <?php
                                    $daysOfWeek = [
                                        'sunday' => 'الأحد',
                                        'monday' => 'الاثنين',
                                        'tuesday' => 'الثلاثاء',
                                        'wednesday' => 'الأربعاء',
                                        'thursday' => 'الخميس',
                                        'friday' => 'الجمعة',
                                        'saturday' => 'السبت',
                                    ];
                                ?>
                                <strong><?php echo e($daysOfWeek[$lesson->day_of_week] ?? $lesson->day_of_week); ?></strong>
                                <br>
                                <small class="text-muted">
                                    <i class="fas fa-clock"></i>
                                    <?php echo e(\Carbon\Carbon::parse($lesson->start_time)->format('H:i')); ?> - 
                                    <?php echo e(\Carbon\Carbon::parse($lesson->end_time)->format('H:i')); ?>

                                </small>
                            </div>
                            <?php else: ?>
                            <span class="text-warning">
                                <i class="fas fa-exclamation-triangle"></i>
                                يحتاج إكمال الإعداد
                            </span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <span class="badge bg-info"><?php echo e($lesson->students_count); ?></span>
                        </td>
                        <td class="text-center">
                            <?php if($attendanceCount > 0): ?>
                                <div class="d-flex align-items-center justify-content-center">
                                    <span class="me-2 fw-bold 
                                        <?php if($attendanceRate >= 90): ?> text-success
                                        <?php elseif($attendanceRate >= 70): ?> text-warning
                                        <?php else: ?> text-danger
                                        <?php endif; ?>">
                                        <?php echo e($attendanceRate); ?>%
                                    </span>
                                    <div class="progress progress-sm" style="width: 50px;">
                                        <div class="progress-bar 
                                            <?php if($attendanceRate >= 90): ?> bg-success
                                            <?php elseif($attendanceRate >= 70): ?> bg-warning
                                            <?php else: ?> bg-danger
                                            <?php endif; ?>" 
                                            style="width: <?php echo e($attendanceRate); ?>%">
                                        </div>
                                    </div>
                                </div>
                                <small class="text-muted d-block"><?php echo e($presentCount); ?>/<?php echo e($attendanceCount); ?></small>
                            <?php else: ?>
                                <span class="text-muted">لا توجد سجلات</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if($lesson->status === 'active'): ?>
                                <span class="badge bg-success">نشط</span>
                            <?php else: ?>
                                <span class="badge bg-secondary">غير نشط</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <a href="<?php echo e(route('teacher.lessons.show', $lesson)); ?>" 
                                   class="btn btn-outline-info" title="عرض التفاصيل">
                                    <i class="fas fa-eye"></i>
                                </a>
                                <a href="<?php echo e(route('teacher.lessons.edit', $lesson)); ?>" 
                                   class="btn btn-outline-warning" title="تعديل">
                                    <i class="fas fa-edit"></i>
                                </a>
                                <a href="<?php echo e(route('teacher.lessons.manage-students', $lesson)); ?>" 
                                   class="btn btn-outline-success" title="إدارة الطلاب">
                                    <i class="fas fa-users"></i>
                                </a>
                                <div class="btn-group btn-group-sm">
                                    <button type="button" class="btn btn-outline-secondary dropdown-toggle" 
                                            data-bs-toggle="dropdown">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>                                    <ul class="dropdown-menu">
                                        <li>
                                            <a class="dropdown-item" 
                                               href="<?php echo e(route('teacher.attendances.lesson', $lesson)); ?>">
                                                <i class="fas fa-eye me-2"></i>مراجعة الحضور
                                            </a>
                                        </li>
                                        <li><hr class="dropdown-divider"></li>
                                        <li>
                                            <form action="<?php echo e(route('teacher.lessons.destroy', $lesson)); ?>" 
                                                  method="POST" 
                                                  onsubmit="return confirm('هل أنت متأكد من حذف هذا الدرس؟')"
                                                  style="display: inline;">
                                                <?php echo csrf_field(); ?>
                                                <?php echo method_field('DELETE'); ?>
                                                <button type="submit" class="dropdown-item text-danger">
                                                    <i class="fas fa-trash me-2"></i>حذف الدرس
                                                </button>
                                            </form>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>

        <!-- Pagination -->
        <?php if($lessons->hasPages()): ?>
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($lessons->links()); ?>

        </div>
        <?php endif; ?>

        <?php else: ?>
        <div class="text-center py-5">
            <i class="fas fa-book-open fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">لا توجد دروس بعد</h5>
            <p class="text-muted">ابدأ بإضافة درسك الأول</p>
            <a href="<?php echo e(route('teacher.lessons.create')); ?>" class="btn btn-success">
                <i class="fas fa-plus"></i> إضافة درس جديد
            </a>
        </div>
        <?php endif; ?>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
.progress-sm {
    height: 6px;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

.text-white-75 {
    color: rgba(255, 255, 255, 0.75) !important;
}

.btn-group-sm > .btn {
    padding: 0.25rem 0.5rem;
    font-size: 0.875rem;
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // تحسين تجربة المستخدم
    const cards = document.querySelectorAll('.card');
    cards.forEach(card => {
        card.addEventListener('mouseenter', function() {
            this.style.transform = 'translateY(-2px)';
        });
        
        card.addEventListener('mouseleave', function() {
            this.style.transform = 'translateY(0)';
        });
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\abdul\OneDrive\Documents\BasmahApp\resources\views/teacher/lessons/index.blade.php ENDPATH**/ ?>