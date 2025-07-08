<?php $__env->startSection('title', 'تفاصيل الدرس - ' . $lesson->subject); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0"><?php echo e($lesson->subject); ?></h1>        <p class="text-muted mb-0">
            <?php if($lesson->day_of_week && $lesson->start_time): ?>
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
                <?php echo e($daysOfWeek[$lesson->day_of_week] ?? $lesson->day_of_week); ?> - 
                <?php echo e(\Carbon\Carbon::parse($lesson->start_time)->format('H:i')); ?>

            <?php else: ?>
                <span class="text-warning">
                    <i class="fas fa-exclamation-triangle"></i>
                    يحتاج إضافة الأوقات والأيام
                </span>
            <?php endif; ?>
        </p>
    </div>    <div class="btn-group">
        <a href="<?php echo e(route('teacher.lessons.edit', $lesson)); ?>" class="btn btn-warning">
            <i class="fas fa-edit"></i> 
            <?php if($lesson->day_of_week && $lesson->start_time): ?>
                تعديل الدرس
            <?php else: ?>
                إكمال إعداد الدرس
            <?php endif; ?>
        </a>
        <?php if($lesson->day_of_week && $lesson->start_time): ?>
        <a href="<?php echo e(route('teacher.lessons.manage-students', $lesson)); ?>" class="btn btn-success">
            <i class="fas fa-users"></i> إدارة الطلاب
        </a>        <a href="<?php echo e(route('teacher.lessons.qr.display', $lesson)); ?>" class="btn btn-primary" target="_blank">
            <i class="fas fa-qrcode"></i> QR Code للحضور
        </a>
        <?php endif; ?>
        <a href="<?php echo e(route('teacher.lessons.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> العودة للدروس
        </a>
    </div>
</div>

<?php if(!$lesson->day_of_week || !$lesson->start_time): ?>
<div class="alert alert-warning mb-4">
    <i class="fas fa-info-circle me-2"></i>
    <strong>يحتاج إكمال الإعداد:</strong> 
    هذا الدرس يحتاج إضافة معلومات إضافية مثل الأوقات والأيام. 
    <a href="<?php echo e(route('teacher.lessons.edit', $lesson)); ?>" class="alert-link">اضغط هنا لإكمال الإعداد</a>
</div>
<?php endif; ?>

<div class="row">
    <!-- معلومات الدرس -->
    <div class="col-lg-8">
        <div class="card mb-4">
            <div class="card-header bg-primary text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-info-circle"></i>
                    معلومات الدرس
                </h5>
            </div>
            <div class="card-body">
                <div class="row">
                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">المادة:</td>
                                <td><span class="badge bg-primary"><?php echo e($lesson->subject); ?></span></td>
                            </tr>                            <tr>
                                <td class="fw-bold">يوم الأسبوع:</td>
                                <td>
                                    <?php if($lesson->day_of_week): ?>
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
                                        <?php echo e($daysOfWeek[$lesson->day_of_week] ?? $lesson->day_of_week); ?>

                                    <?php else: ?>
                                        <span class="text-muted">غير محدد</span>
                                    <?php endif; ?>
                                </td>
                            </tr><tr>
                                <td class="fw-bold">الوقت:</td>
                                <td>
                                    <?php if($lesson->start_time && $lesson->end_time): ?>
                                        <i class="fas fa-clock text-info"></i>
                                        <?php echo e(\Carbon\Carbon::parse($lesson->start_time)->format('H:i')); ?> - 
                                        <?php echo e(\Carbon\Carbon::parse($lesson->end_time)->format('H:i')); ?>

                                    <?php else: ?>
                                        <span class="text-muted">غير محدد</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                        </table>
                    </div>                    <div class="col-md-6">
                        <table class="table table-borderless">
                            <tr>
                                <td class="fw-bold">عدد الطلاب:</td>
                                <td><?php echo e($lesson->students_count); ?></td>
                            </tr>
                            <tr>
                                <td class="fw-bold">الحالة:</td>
                                <td>
                                    <?php if($lesson->status === 'active'): ?>
                                        <span class="badge bg-success">نشط</span>
                                    <?php else: ?>
                                        <span class="badge bg-secondary">غير نشط</span>
                                    <?php endif; ?>
                                </td>
                            </tr>
                            <tr>
                                <td class="fw-bold">تاريخ الإنشاء:</td>
                                <td><?php echo e($lesson->created_at->format('Y/m/d')); ?></td>
                            </tr>
                        </table>
                    </div>
                </div>
                
                <?php if($lesson->description): ?>
                <div class="mt-3">
                    <h6 class="fw-bold">وصف الدرس:</h6>
                    <p class="text-muted"><?php echo e($lesson->description); ?></p>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- إحصائيات الحضور -->
        <div class="card mb-4">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-pie"></i>
                    إحصائيات الحضور
                </h5>
            </div>
            <div class="card-body">
                <?php if($attendanceStats['total'] > 0): ?>
                <div class="row text-center mb-4">
                    <div class="col-3">
                        <div class="border-end">
                            <div class="h4 text-success mb-0"><?php echo e($attendanceStats['present']); ?></div>
                            <small class="text-muted">حاضر</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="border-end">
                            <div class="h4 text-danger mb-0"><?php echo e($attendanceStats['absent']); ?></div>
                            <small class="text-muted">غائب</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="border-end">
                            <div class="h4 text-warning mb-0"><?php echo e($attendanceStats['late']); ?></div>
                            <small class="text-muted">متأخر</small>
                        </div>
                    </div>
                    <div class="col-3">
                        <div class="h4 text-info mb-0"><?php echo e($attendanceStats['excused']); ?></div>
                        <small class="text-muted">معذور</small>
                    </div>
                </div>
                
                <div class="mt-3">
                    <div class="d-flex justify-content-between mb-2">
                        <span>معدل الحضور</span>
                        <span class="fw-bold text-success"><?php echo e($attendanceStats['attendance_rate']); ?>%</span>
                    </div>
                    <div class="progress">
                        <div class="progress-bar bg-success" style="width: <?php echo e($attendanceStats['attendance_rate']); ?>%"></div>
                    </div>
                </div>                <?php else: ?>
                <div class="text-center py-4">
                    <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                    <h6 class="text-muted">لا توجد سجلات حضور بعد</h6>
                    <p class="text-muted">يمكن للطلاب تسجيل الحضور باستخدام QR Code</p>
                    <div class="alert alert-info">
                        <i class="fas fa-qrcode"></i> تسجيل الحضور متاح فقط للطلاب عبر QR Code
                    </div>
                </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- آخر سجلات الحضور -->
        <?php if($recentAttendances->count() > 0): ?>
        <div class="card">
            <div class="card-header bg-light">
                <h5 class="card-title mb-0">
                    <i class="fas fa-history"></i>
                    آخر سجلات الحضور
                </h5>
            </div>
            <div class="card-body">
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>الطالب</th>
                                <th class="text-center">الحالة</th>
                                <th class="text-center">التاريخ</th>
                                <th class="text-center">الوقت</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $__currentLoopData = $recentAttendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <div class="avatar-circle me-2">
                                            <?php echo e(strtoupper(substr($attendance->student->name, 0, 1))); ?>

                                        </div>
                                        <?php echo e($attendance->student->name); ?>

                                    </div>
                                </td>
                                <td class="text-center">
                                    <?php switch($attendance->status):
                                        case ('present'): ?>
                                            <span class="badge bg-success">
                                                <i class="fas fa-check"></i> حاضر
                                            </span>
                                            <?php break; ?>
                                        <?php case ('absent'): ?>
                                            <span class="badge bg-danger">
                                                <i class="fas fa-times"></i> غائب
                                            </span>
                                            <?php break; ?>
                                        <?php case ('late'): ?>
                                            <span class="badge bg-warning">
                                                <i class="fas fa-clock"></i> متأخر
                                            </span>
                                            <?php break; ?>
                                        <?php case ('excused'): ?>
                                            <span class="badge bg-info">
                                                <i class="fas fa-user-check"></i> معذور
                                            </span>
                                            <?php break; ?>
                                    <?php endswitch; ?>
                                </td>
                                <td class="text-center"><?php echo e($attendance->date->format('Y/m/d')); ?></td>
                                <td class="text-center text-muted"><?php echo e($attendance->created_at->format('H:i')); ?></td>
                            </tr>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </tbody>
                    </table>
                </div>
                
                <div class="text-center mt-3">
                    <a href="<?php echo e(route('teacher.attendances.index', ['lesson_id' => $lesson->id])); ?>" class="btn btn-outline-primary">
                        عرض جميع سجلات الحضور <i class="fas fa-arrow-left"></i>
                    </a>
                </div>
            </div>
        </div>
        <?php endif; ?>
    </div>

    <!-- الشريط الجانبي -->
    <div class="col-lg-4">
        <!-- إجراءات سريعة -->
        <div class="card mb-4">
            <div class="card-header bg-success text-white">
                <h6 class="card-title mb-0">
                    <i class="fas fa-bolt"></i>
                    إجراءات سريعة
                </h6>
            </div>            <div class="card-body">
                <div class="d-grid gap-2">
                    <div class="alert alert-info">
                        <i class="fas fa-info-circle"></i> يمكن للطلاب فقط تسجيل الحضور عبر QR Code
                    </div>
                    <a href="<?php echo e(route('teacher.lessons.manage-students', $lesson)); ?>" 
                       class="btn btn-info">
                        <i class="fas fa-users"></i> إدارة طلاب الدرس
                    </a>
                    <a href="<?php echo e(route('teacher.lessons.edit', $lesson)); ?>" 
                       class="btn btn-warning">
                        <i class="fas fa-edit"></i> تعديل معلومات الدرس
                    </a>
                </div>
            </div>
        </div>

        <!-- الطلاب المسجلين -->
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0">
                    <i class="fas fa-users"></i>
                    الطلاب المسجلين (<?php echo e($lesson->students_count); ?>)
                </h6>
            </div>
            <div class="card-body">
                <?php if($lesson->students->count() > 0): ?>
                    <?php $__currentLoopData = $lesson->students->take(10); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex align-items-center mb-2 p-2 border rounded">
                        <div class="avatar-circle me-2">
                            <?php echo e(strtoupper(substr($student->name, 0, 1))); ?>

                        </div>
                        <div class="flex-grow-1">
                            <div class="fw-bold"><?php echo e($student->name); ?></div>
                            <small class="text-muted"><?php echo e($student->email); ?></small>
                        </div>
                        <?php
                            $studentAttendances = $lesson->attendances->where('student_id', $student->id);
                            $studentTotal = $studentAttendances->count();
                            $studentPresent = $studentAttendances->where('status', 'present')->count();
                            $studentRate = $studentTotal > 0 ? round(($studentPresent / $studentTotal) * 100) : 0;
                        ?>
                        <span class="badge 
                            <?php if($studentRate >= 90): ?> bg-success
                            <?php elseif($studentRate >= 70): ?> bg-warning
                            <?php else: ?> bg-danger
                            <?php endif; ?>">
                            <?php echo e($studentRate); ?>%
                        </span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                    
                    <?php if($lesson->students->count() > 10): ?>
                    <div class="text-center mt-3">
                        <a href="<?php echo e(route('teacher.lessons.manage-students', $lesson)); ?>" class="btn btn-sm btn-outline-primary">
                            عرض جميع الطلاب (<?php echo e($lesson->students->count()); ?>)
                        </a>
                    </div>
                    <?php endif; ?>
                <?php else: ?>
                    <div class="text-center py-3">
                        <i class="fas fa-user-plus fa-2x text-muted mb-2"></i>
                        <p class="text-muted mb-2">لا يوجد طلاب مسجلين</p>
                        <a href="<?php echo e(route('teacher.lessons.manage-students', $lesson)); ?>" class="btn btn-sm btn-success">
                            إضافة طلاب
                        </a>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
.avatar-circle {
    width: 35px;
    height: 35px;
    background: linear-gradient(45deg, #007bff, #0056b3);
    color: white;
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 14px;
}

.border-end {
    border-right: 1px solid #dee2e6 !important;
}

.card {
    box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    border: 1px solid rgba(0, 0, 0, 0.125);
    transition: all 0.3s ease;
}

.card:hover {
    box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
}

@media (max-width: 768px) {
    .border-end {
        border-right: none !important;
    }
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u994369532/basmah/resources/views/teacher/lessons/show.blade.php ENDPATH**/ ?>