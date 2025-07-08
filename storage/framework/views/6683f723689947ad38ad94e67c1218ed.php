<?php $__env->startSection('title', 'سجلات الحضور - ' . $lesson->subject); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">    <div>
        <h1 class="h3 mb-0">سجلات الحضور</h1>
        <p class="text-muted mb-0"><?php echo e($lesson->subject); ?></p>
    </div>    <div class="btn-group">
        <a href="<?php echo e(route('teacher.lessons.show', $lesson)); ?>" class="btn btn-outline-primary">
            <i class="fas fa-eye"></i> عرض الدرس
        </a>
        <div class="alert alert-info mb-0" style="font-size: 0.85rem;">
            <i class="fas fa-info-circle me-1"></i>
            تسجيل الحضور يتم عبر الطلاب باستخدام QR Code
        </div>
    </div>
</div>

<!-- إحصائيات الحضور -->
<div class="row mb-4">
    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-primary text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-75 small">إجمالي السجلات</div>
                        <div class="h3 mb-0"><?php echo e($stats['total']); ?></div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clipboard-list fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-success text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-75 small">حاضر</div>
                        <div class="h3 mb-0"><?php echo e($stats['present']); ?></div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-check-circle fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-warning text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-75 small">متأخر</div>
                        <div class="h3 mb-0"><?php echo e($stats['late']); ?></div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-clock fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col-lg-3 col-md-6 mb-3">
        <div class="card bg-danger text-white">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <div class="text-white-75 small">غائب</div>
                        <div class="h3 mb-0"><?php echo e($stats['absent']); ?></div>
                    </div>
                    <div class="align-self-center">
                        <i class="fas fa-times-circle fa-2x text-white-50"></i>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- نسبة الحضور -->
<div class="card mb-4">
    <div class="card-body">
        <h6 class="card-title">معدل الحضور</h6>
        <div class="progress" style="height: 25px;">
            <div class="progress-bar bg-success" 
                 role="progressbar" 
                 style="width: <?php echo e($stats['present_rate']); ?>%"
                 aria-valuenow="<?php echo e($stats['present_rate']); ?>" 
                 aria-valuemin="0" 
                 aria-valuemax="100">
                <?php echo e($stats['present_rate']); ?>%
            </div>
        </div>
    </div>
</div>

<!-- جدول سجلات الحضور -->
<div class="card">
    <div class="card-header">
        <h5 class="card-title mb-0">
            <i class="fas fa-list"></i>
            سجلات الحضور (<?php echo e($attendances->total()); ?>)
        </h5>
    </div>
    <div class="card-body">
        <?php if($attendances->count() > 0): ?>
        <div class="table-responsive">
            <table class="table table-hover">
                <thead>
                    <tr>
                        <th>الطالب</th>
                        <th>التاريخ</th>
                        <th>الوقت</th>
                        <th class="text-center">الحالة</th>
                        <th>ملاحظات</th>
                        <th class="text-center">الإجراءات</th>
                    </tr>
                </thead>
                <tbody>
                    <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <tr>
                        <td>
                            <div>
                                <strong><?php echo e($attendance->student->name); ?></strong>
                                <br>
                                <small class="text-muted"><?php echo e($attendance->student->email); ?></small>
                            </div>
                        </td>
                        <td><?php echo e(\Carbon\Carbon::parse($attendance->date)->format('Y/m/d')); ?></td>
                        <td>
                            <?php if($attendance->time): ?>
                                <?php echo e(\Carbon\Carbon::parse($attendance->time)->format('H:i')); ?>

                            <?php else: ?>
                                <span class="text-muted">غير محدد</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <?php if($attendance->status === 'present'): ?>
                                <span class="badge bg-success">حاضر</span>
                            <?php elseif($attendance->status === 'late'): ?>
                                <span class="badge bg-warning">متأخر</span>
                            <?php else: ?>
                                <span class="badge bg-danger">غائب</span>
                            <?php endif; ?>
                        </td>
                        <td>
                            <?php if($attendance->notes): ?>
                                <?php echo e(Str::limit($attendance->notes, 50)); ?>

                            <?php else: ?>
                                <span class="text-muted">لا توجد ملاحظات</span>
                            <?php endif; ?>
                        </td>
                        <td class="text-center">
                            <div class="btn-group btn-group-sm">
                                <button type="button" 
                                        class="btn btn-outline-primary"
                                        data-bs-toggle="modal"
                                        data-bs-target="#viewModal<?php echo e($attendance->id); ?>">
                                    <i class="fas fa-eye"></i>
                                </button>
                                <button type="button" 
                                        class="btn btn-outline-warning"
                                        data-bs-toggle="modal"
                                        data-bs-target="#editModal<?php echo e($attendance->id); ?>">
                                    <i class="fas fa-edit"></i>
                                </button>
                            </div>
                        </td>
                    </tr>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                </tbody>
            </table>
        </div>
        
        <!-- Pagination -->
        <div class="d-flex justify-content-center">
            <?php echo e($attendances->links()); ?>

        </div>
        <?php else: ?>        <div class="text-center py-5">
            <i class="fas fa-clipboard-list fa-3x text-muted mb-3"></i>
            <h5 class="text-muted">لا توجد سجلات حضور</h5>
            <p class="text-muted">لم يتم تسجيل أي حضور لهذا الدرس بعد</p>
            <div class="alert alert-info mt-3">
                <i class="fas fa-info-circle"></i>
                تسجيل الحضور يتم عبر الطلاب باستخدام QR Code
            </div>
        </div>
        <?php endif; ?>
    </div>
</div>

<!-- Modals للعرض والتعديل (يمكن إضافتها لاحقاً) -->
<?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!-- View Modal -->
<div class="modal fade" id="viewModal<?php echo e($attendance->id); ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تفاصيل الحضور</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <table class="table table-borderless">
                    <tr>
                        <td><strong>الطالب:</strong></td>
                        <td><?php echo e($attendance->student->name); ?></td>
                    </tr>
                    <tr>
                        <td><strong>التاريخ:</strong></td>
                        <td><?php echo e(\Carbon\Carbon::parse($attendance->date)->format('Y/m/d')); ?></td>
                    </tr>
                    <tr>
                        <td><strong>الوقت:</strong></td>
                        <td><?php echo e($attendance->time ? \Carbon\Carbon::parse($attendance->time)->format('H:i') : 'غير محدد'); ?></td>
                    </tr>
                    <tr>
                        <td><strong>الحالة:</strong></td>
                        <td>
                            <?php if($attendance->status === 'present'): ?>
                                <span class="badge bg-success">حاضر</span>
                            <?php elseif($attendance->status === 'late'): ?>
                                <span class="badge bg-warning">متأخر</span>
                            <?php else: ?>
                                <span class="badge bg-danger">غائب</span>
                            <?php endif; ?>
                        </td>
                    </tr>
                    <?php if($attendance->notes): ?>
                    <tr>
                        <td><strong>ملاحظات:</strong></td>
                        <td><?php echo e($attendance->notes); ?></td>
                    </tr>
                    <?php endif; ?>
                </table>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إغلاق</button>
            </div>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<!-- Edit Modals -->
<?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
<!-- تعديل حالة الحضور Modal -->
<div class="modal fade" id="editModal<?php echo e($attendance->id); ?>" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تعديل حالة الحضور</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <form action="<?php echo e(route('teacher.attendances.update', $attendance)); ?>" method="POST">
                <?php echo csrf_field(); ?>
                <?php echo method_field('PUT'); ?>
                <div class="modal-body">
                    <div class="mb-3">
                        <label class="form-label"><strong>الطالب:</strong></label>
                        <p class="form-control-plaintext"><?php echo e($attendance->student->name); ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label"><strong>التاريخ:</strong></label>
                        <p class="form-control-plaintext"><?php echo e(\Carbon\Carbon::parse($attendance->date)->format('Y/m/d')); ?></p>
                    </div>
                    
                    <div class="mb-3">
                        <label for="status<?php echo e($attendance->id); ?>" class="form-label">حالة الحضور <span class="text-danger">*</span></label>
                        <select class="form-select" id="status<?php echo e($attendance->id); ?>" name="status" required>
                            <option value="present" <?php echo e($attendance->status === 'present' ? 'selected' : ''); ?>>حاضر</option>
                            <option value="late" <?php echo e($attendance->status === 'late' ? 'selected' : ''); ?>>متأخر</option>
                            <option value="absent" <?php echo e($attendance->status === 'absent' ? 'selected' : ''); ?>>غائب</option>
                            <option value="excused" <?php echo e($attendance->status === 'excused' ? 'selected' : ''); ?>>غياب بعذر</option>
                        </select>
                    </div>
                    
                    <div class="mb-3">
                        <label for="notes<?php echo e($attendance->id); ?>" class="form-label">ملاحظات</label>
                        <textarea class="form-control" id="notes<?php echo e($attendance->id); ?>" name="notes" rows="3"><?php echo e($attendance->notes); ?></textarea>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                    <button type="submit" class="btn btn-primary">حفظ التعديلات</button>
                </div>
            </form>
        </div>
    </div>
</div>
<?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>

<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u994369532/basmah/resources/views/teacher/attendances/lesson.blade.php ENDPATH**/ ?>