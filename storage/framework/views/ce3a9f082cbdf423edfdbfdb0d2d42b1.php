<?php $__env->startSection('title', 'عرض الدرس'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="d-flex justify-content-between align-items-center mb-4">
                <h1 class="h3 mb-0">تفاصيل الدرس</h1>
                <div>
                    <a href="<?php echo e(route('admin.lessons.edit', $lesson)); ?>" class="btn btn-warning me-2">
                        <i class="fas fa-edit me-2"></i>تعديل
                    </a>
                    <a href="<?php echo e(route('admin.lessons.index')); ?>" class="btn btn-secondary">
                        <i class="fas fa-arrow-right me-2"></i>العودة للقائمة
                    </a>
                </div>
            </div>

            <div class="row">
                <!-- Lesson Details -->
                <div class="col-lg-8">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-book me-2"></i>معلومات الدرس
                            </h5>
                        </div>
                        <div class="card-body">
                            <table class="table table-borderless">
                                <tr>
                                    <th style="width: 200px;">اسم الدرس:</th>
                                    <td><?php echo e($lesson->name); ?></td>
                                </tr>
                                <tr>
                                    <th>المادة:</th>
                                    <td><?php echo e($lesson->subject ?? 'غير محدد'); ?></td>
                                </tr>
                                <tr>
                                    <th>المعلم:</th>
                                    <td>
                                        <span class="badge bg-primary"><?php echo e($lesson->teacher->name); ?></span>
                                    </td>
                                </tr>
                                <tr>
                                    <th>وقت الدرس:</th>
                                    <td><?php echo e($lesson->schedule_time ?? 'غير محدد'); ?></td>
                                </tr>
                                <tr>
                                    <th>تاريخ الإنشاء:</th>
                                    <td><?php echo e($lesson->created_at->format('Y/m/d - H:i')); ?></td>
                                </tr>
                                <tr>
                                    <th>آخر تحديث:</th>
                                    <td><?php echo e($lesson->updated_at->format('Y/m/d - H:i')); ?></td>
                                </tr>
                                <?php if($lesson->description): ?>
                                <tr>
                                    <th>الوصف:</th>
                                    <td><?php echo e($lesson->description); ?></td>
                                </tr>
                                <?php endif; ?>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Statistics -->
                <div class="col-lg-4">
                    <div class="card shadow mb-4">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-chart-bar me-2"></i>الإحصائيات
                            </h5>
                        </div>
                        <div class="card-body">
                            <div class="text-center mb-3">
                                <h3 class="text-primary"><?php echo e($lesson->students->count()); ?></h3>
                                <small class="text-muted">عدد الطلاب المسجلين</small>
                            </div>
                            
                            <div class="text-center mb-3">
                                <h3 class="text-success"><?php echo e($lesson->attendances->count()); ?></h3>
                                <small class="text-muted">إجمالي سجلات الحضور</small>
                            </div>
                            
                            <div class="text-center">
                                <h3 class="text-info"><?php echo e($lesson->attendances()->whereDate('date', today())->count()); ?></h3>
                                <small class="text-muted">حضور اليوم</small>
                            </div>
                        </div>
                    </div>

                    <!-- Quick Actions -->
                    <div class="card shadow">
                        <div class="card-header">
                            <h5 class="card-title mb-0">
                                <i class="fas fa-lightning-bolt me-2"></i>إجراءات سريعة
                            </h5>
                        </div>                        <div class="card-body">
                            <div class="alert alert-info mb-2">
                                <i class="fas fa-qrcode me-2"></i>تسجيل الحضور متاح للطلاب فقط عبر QR Code
                            </div>
                            <a href="<?php echo e(route('admin.attendances.index', ['lesson_id' => $lesson->id])); ?>" 
                               class="btn btn-info btn-block">
                                <i class="fas fa-list me-2"></i>مراجعة سجلات الحضور
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Students List -->
            <div class="card shadow">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-users me-2"></i>الطلاب المسجلين (<?php echo e($lesson->students->count()); ?>)
                    </h5>
                </div>
                <div class="card-body">
                    <?php if($lesson->students->count() > 0): ?>
                        <div class="row">
                            <?php $__currentLoopData = $lesson->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div class="col-md-4 col-lg-3 mb-3">
                                    <div class="card h-100">
                                        <div class="card-body text-center">
                                            <i class="fas fa-user-graduate fa-2x text-primary mb-2"></i>
                                            <h6 class="card-title"><?php echo e($student->name); ?></h6>
                                            <small class="text-muted"><?php echo e($student->email); ?></small>
                                        </div>
                                    </div>
                                </div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php else: ?>
                        <div class="text-center py-4">
                            <i class="fas fa-users fa-3x text-muted mb-3"></i>
                            <p class="text-muted">لا يوجد طلاب مسجلين في هذا الدرس</p>
                        </div>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Recent Attendances -->
            <?php if($lesson->attendances->count() > 0): ?>
            <div class="card shadow mt-4">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-clock me-2"></i>آخر سجلات الحضور
                    </h5>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped">
                            <thead>
                                <tr>
                                    <th>الطالب</th>
                                    <th>التاريخ</th>
                                    <th>الحالة</th>
                                    <th>ملاحظات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $lesson->attendances()->latest()->take(10)->get(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $attendance): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <tr>
                                        <td><?php echo e($attendance->student->name); ?></td>
                                        <td><?php echo e($attendance->date); ?></td>
                                        <td>
                                            <?php if($attendance->status === 'present'): ?>
                                                <span class="badge bg-success">حاضر</span>
                                            <?php elseif($attendance->status === 'absent'): ?>
                                                <span class="badge bg-danger">غائب</span>
                                            <?php else: ?>
                                                <span class="badge bg-warning">متأخر</span>
                                            <?php endif; ?>
                                        </td>
                                        <td><?php echo e($attendance->notes ?? '-'); ?></td>
                                    </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <?php if($lesson->attendances->count() > 10): ?>
                        <div class="text-center mt-3">
                            <a href="<?php echo e(route('admin.attendances.index', ['lesson_id' => $lesson->id])); ?>" 
                               class="btn btn-outline-primary">
                                عرض جميع سجلات الحضور
                            </a>
                        </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endif; ?>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u994369532/basmah/resources/views/admin/lessons/show.blade.php ENDPATH**/ ?>