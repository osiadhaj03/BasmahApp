<?php $__env->startSection('title', 'تقارير الحضور'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>
                        تقارير الحضور
                    </h4>
                    <a href="<?php echo e(route('admin.attendances.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-left me-2"></i>
                        العودة للحضور
                    </a>
                </div>
                
                <div class="card-body">
                    <!-- فلاتر التقرير -->
                    <form method="GET" class="mb-4">
                        <div class="row">
                            <div class="col-md-3 mb-3">
                                <label for="lesson_id" class="form-label">الدرس</label>
                                <select class="form-control" id="lesson_id" name="lesson_id">
                                    <option value="">جميع الدروس</option>
                                    <?php $__currentLoopData = $lessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($lesson->id); ?>" 
                                                <?php echo e(request('lesson_id') == $lesson->id ? 'selected' : ''); ?>>
                                            <?php echo e($lesson->subject); ?> - <?php echo e($lesson->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-3 mb-3">
                                <label for="student_id" class="form-label">الطالب</label>
                                <select class="form-control" id="student_id" name="student_id">
                                    <option value="">جميع الطلاب</option>
                                    <?php $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                        <option value="<?php echo e($student->id); ?>" 
                                                <?php echo e(request('student_id') == $student->id ? 'selected' : ''); ?>>
                                            <?php echo e($student->name); ?>

                                        </option>
                                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                                </select>
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="start_date" class="form-label">من تاريخ</label>
                                <input type="date" class="form-control" id="start_date" name="start_date" 
                                       value="<?php echo e(request('start_date', date('Y-m-01'))); ?>">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label for="end_date" class="form-label">إلى تاريخ</label>
                                <input type="date" class="form-control" id="end_date" name="end_date" 
                                       value="<?php echo e(request('end_date', date('Y-m-d'))); ?>">
                            </div>
                            <div class="col-md-2 mb-3">
                                <label class="form-label">&nbsp;</label>
                                <button type="submit" class="btn btn-primary w-100">
                                    <i class="fas fa-search me-2"></i>
                                    تصفية
                                </button>
                            </div>
                        </div>
                    </form>

                    <!-- إحصائيات سريعة -->
                    <?php if(isset($statistics)): ?>
                    <div class="row mb-4">
                        <div class="col-md-3">
                            <div class="card bg-success text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-check-circle fa-2x mb-2"></i>
                                    <h4><?php echo e($statistics['present']); ?></h4>
                                    <small>حاضر</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-warning text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-clock fa-2x mb-2"></i>
                                    <h4><?php echo e($statistics['late']); ?></h4>
                                    <small>متأخر</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-danger text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-times-circle fa-2x mb-2"></i>
                                    <h4><?php echo e($statistics['absent']); ?></h4>
                                    <small>غائب</small>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <div class="card bg-info text-white">
                                <div class="card-body text-center">
                                    <i class="fas fa-user-check fa-2x mb-2"></i>
                                    <h4><?php echo e($statistics['excused']); ?></h4>
                                    <small>بعذر</small>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- نسبة الحضور -->
                    <div class="row mb-4">
                        <div class="col-12">
                            <div class="card">
                                <div class="card-body">
                                    <h5 class="card-title">نسبة الحضور العامة</h5>
                                    <?php
                                        $total = $statistics['present'] + $statistics['late'] + $statistics['absent'] + $statistics['excused'];
                                        $attendanceRate = $total > 0 ? round((($statistics['present'] + $statistics['late']) / $total) * 100, 1) : 0;
                                    ?>
                                    <div class="progress mb-2" style="height: 25px;">
                                        <div class="progress-bar bg-success" role="progressbar" 
                                             style="width: <?php echo e($attendanceRate); ?>%" 
                                             aria-valuenow="<?php echo e($attendanceRate); ?>" aria-valuemin="0" aria-valuemax="100">
                                            <?php echo e($attendanceRate); ?>%
                                        </div>
                                    </div>
                                    <small class="text-muted">إجمالي السجلات: <?php echo e($total); ?></small>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>

                    <!-- جدول التفاصيل -->
                    <?php if(isset($attendances) && $attendances->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead class="table-dark">
                                <tr>
                                    <th>التاريخ</th>
                                    <th>الطالب</th>
                                    <th>المادة</th>
                                    <?php if(auth()->user()->role === 'admin'): ?>
                                        <th>المعلم</th>
                                    <?php endif; ?>
                                    <th>الحالة</th>
                                    <th>الملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $attendances; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td><?php echo e($attendance->date->format('Y/m/d')); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <?php echo e(substr($attendance->student->name, 0, 2)); ?>

                                            </div>
                                            <?php echo e($attendance->student->name); ?>

                                        </div>
                                    </td>
                                    <td><?php echo e($attendance->lesson->subject); ?></td>
                                    <?php if(auth()->user()->role === 'admin'): ?>
                                        <td><?php echo e($attendance->lesson->teacher->name); ?></td>
                                    <?php endif; ?>
                                    <td>
                                        <?php switch($attendance->status):
                                            case ('present'): ?>
                                                <span class="badge bg-success">حاضر</span>
                                                <?php break; ?>
                                            <?php case ('absent'): ?>
                                                <span class="badge bg-danger">غائب</span>
                                                <?php break; ?>
                                            <?php case ('late'): ?>
                                                <span class="badge bg-warning">متأخر</span>
                                                <?php break; ?>
                                            <?php case ('excused'): ?>
                                                <span class="badge bg-info">بعذر</span>
                                                <?php break; ?>
                                        <?php endswitch; ?>
                                    </td>
                                    <td><?php echo e($attendance->notes ?: '-'); ?></td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center mt-4">
                        <?php echo e($attendances->appends(request()->query())->links()); ?>

                    </div>
                    <?php else: ?>
                        <div class="text-center py-5">
                            <i class="fas fa-chart-line fa-3x text-muted mb-3"></i>
                            <h5 class="text-muted">لا توجد بيانات للعرض</h5>
                            <p class="text-muted">جرب تعديل الفلاتر أو إضافة المزيد من سجلات الحضور</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('styles'); ?>
<style>
.avatar-sm {
    width: 32px;
    height: 32px;
    font-size: 12px;
    font-weight: bold;
}
</style>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u994369532/basmah/resources/views/admin/attendances/reports.blade.php ENDPATH**/ ?>