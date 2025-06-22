

<?php $__env->startSection('title', 'سجل حضور الطالب'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <!-- Header -->
    <div class="row mb-4">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-body">
                    <div class="row align-items-center">
                        <div class="col">
                            <h4 class="mb-1">
                                <i class="fas fa-user-clock me-2 text-primary"></i>
                                سجل حضور الطالب
                            </h4>
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb mb-0">
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo e(route('teacher.dashboard')); ?>">لوحة التحكم</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo e(route('teacher.lessons.index')); ?>">الدروس</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo e(route('teacher.lessons.show', $lesson)); ?>"><?php echo e($lesson->subject); ?></a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="<?php echo e(route('teacher.lessons.manage-students', $lesson)); ?>">إدارة الطلاب</a>
                                    </li>
                                    <li class="breadcrumb-item active"><?php echo e($student->name); ?></li>
                                </ol>
                            </nav>
                        </div>
                        <div class="col-auto">
                            <a href="<?php echo e(route('teacher.lessons.manage-students', $lesson)); ?>" class="btn btn-outline-secondary">
                                <i class="fas fa-arrow-right me-2"></i>العودة
                            </a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- معلومات الدرس والطالب -->
    <div class="row mb-4">
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-book me-2"></i>
                        معلومات الدرس
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="fw-bold text-muted">المادة:</td>
                            <td><?php echo e($lesson->subject); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">الوصف:</td>
                            <td><?php echo e($lesson->description ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">القاعة:</td>
                            <td><?php echo e($lesson->classroom ?? '-'); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">المستوى:</td>
                            <td><?php echo e($lesson->level ?? '-'); ?></td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
        <div class="col-md-6">
            <div class="card border-0 shadow-sm h-100">
                <div class="card-header bg-info text-white">
                    <h5 class="mb-0">
                        <i class="fas fa-user me-2"></i>
                        معلومات الطالب
                    </h5>
                </div>
                <div class="card-body">
                    <table class="table table-sm table-borderless">
                        <tr>
                            <td class="fw-bold text-muted">الاسم:</td>
                            <td><?php echo e($student->name); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">البريد الإلكتروني:</td>
                            <td><?php echo e($student->email); ?></td>
                        </tr>
                        <tr>
                            <td class="fw-bold text-muted">نسبة الحضور:</td>
                            <td>
                                <span class="badge <?php echo e($stats['attendance_rate'] >= 80 ? 'bg-success' : ($stats['attendance_rate'] >= 60 ? 'bg-warning' : 'bg-danger')); ?> fs-6">
                                    <?php echo e($stats['attendance_rate']); ?>%
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
        </div>
    </div>

    <!-- إحصائيات الحضور -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card bg-primary text-white border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-clipboard-list fa-2x mb-2"></i>
                    <h3 class="mb-0"><?php echo e($stats['total']); ?></h3>
                    <small>إجمالي السجلات</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-user-check fa-2x mb-2"></i>
                    <h3 class="mb-0"><?php echo e($stats['present']); ?></h3>
                    <small>حاضر</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-user-clock fa-2x mb-2"></i>
                    <h3 class="mb-0"><?php echo e($stats['late']); ?></h3>
                    <small>متأخر</small>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-danger text-white border-0 shadow-sm">
                <div class="card-body text-center">
                    <i class="fas fa-user-times fa-2x mb-2"></i>
                    <h3 class="mb-0"><?php echo e($stats['absent']); ?></h3>
                    <small>غائب</small>
                </div>
            </div>
        </div>
    </div>

    <!-- جدول سجلات الحضور -->
    <div class="row">
        <div class="col-12">
            <div class="card border-0 shadow-sm">
                <div class="card-header">
                    <h5 class="mb-0">
                        <i class="fas fa-history me-2"></i>
                        سجل الحضور التفصيلي
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($attendances->count() > 0): ?>
                        <div class="table-responsive">
                            <table class="table table-hover align-middle">
                                <thead class="table-light">
                                    <tr>
                                        <th>التاريخ</th>
                                        <th>الحالة</th>
                                        <th>الملاحظات</th>
                                        <th>وقت التسجيل</th>
                                        <th class="text-center">الإجراءات</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <tr>
                                            <td>
                                                <strong><?php echo e($attendance->date->format('Y/m/d')); ?></strong>
                                                <br>
                                                <small class="text-muted"><?php echo e($attendance->date->format('l')); ?></small>
                                            </td>
                                            <td>
                                                <?php
                                                    $statusConfig = [
                                                        'present' => ['class' => 'success', 'icon' => 'check', 'text' => 'حاضر'],
                                                        'absent' => ['class' => 'danger', 'icon' => 'times', 'text' => 'غائب'],
                                                        'late' => ['class' => 'warning', 'icon' => 'clock', 'text' => 'متأخر'],
                                                        'excused' => ['class' => 'info', 'icon' => 'user-shield', 'text' => 'معذور']
                                                    ];
                                                    $config = $statusConfig[$attendance->status] ?? $statusConfig['absent'];
                                                ?>
                                                <span class="badge bg-<?php echo e($config['class']); ?>">
                                                    <i class="fas fa-<?php echo e($config['icon']); ?> me-1"></i>
                                                    <?php echo e($config['text']); ?>

                                                </span>
                                            </td>
                                            <td>
                                                <?php if($attendance->notes): ?>
                                                    <span title="<?php echo e($attendance->notes); ?>">
                                                        <?php echo e(Str::limit($attendance->notes, 30)); ?>

                                                    </span>
                                                <?php else: ?>
                                                    <span class="text-muted">-</span>
                                                <?php endif; ?>
                                            </td>
                                            <td>
                                                <small class="text-muted">
                                                    <?php echo e($attendance->created_at->format('Y/m/d H:i')); ?>

                                                </small>
                                            </td>
                                            <td class="text-center">
                                                <button class="btn btn-sm btn-outline-primary" 
                                                        onclick="editAttendance(<?php echo e($attendance->id); ?>, '<?php echo e($attendance->status); ?>', '<?php echo e($attendance->notes); ?>')"
                                                        data-bs-toggle="modal" 
                                                        data-bs-target="#editAttendanceModal">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                            </td>
                                        </tr>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </tbody>
                            </table>
                        </div>
                        
                        <!-- Pagination -->
                        <div class="d-flex justify-content-center mt-3">
                            <?php echo e($attendances->links()); ?>

                        </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد سجلات حضور</h5>
                            <p class="text-muted">لم يسجل هذا الطالب حضوراً في هذا الدرس بعد</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal لتعديل الحضور -->
<div class="modal fade" id="editAttendanceModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل حالة الحضور</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form id="editAttendanceForm" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label">حالة الحضور</label>
                        <select name="status" id="editStatus" class="form-select" required>
                            <option value="present">حاضر</option>
                            <option value="absent">غائب</option>
                            <option value="late">متأخر</option>
                            <option value="excused">معذور</option>
                        </select>
                    </div>
                    <div class="mb-3">
                        <label class="form-label">الملاحظات</label>
                        <textarea name="notes" id="editNotes" class="form-control" rows="3"></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التغييرات</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function editAttendance(id, status, notes) {
    const form = document.getElementById('editAttendanceForm');
    const statusSelect = document.getElementById('editStatus');
    const notesTextarea = document.getElementById('editNotes');
    
    form.action = `<?php echo e(url('/teacher/attendances')); ?>/${id}`;
    statusSelect.value = status;
    notesTextarea.value = notes || '';
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\abdul\OneDrive\Documents\BasmahApp\resources\views/teacher/attendances/student.blade.php ENDPATH**/ ?>