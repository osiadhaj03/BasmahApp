

<?php $__env->startSection('title', 'الطلاب'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row">
        <div class="col-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h4 class="mb-0">
                        <i class="fas fa-user-graduate me-2"></i>
                        الطلاب
                    </h4>
                    <div>
                        <a href="<?php echo e(route('admin.users.create')); ?>?role=student" class="btn btn-info">
                            <i class="fas fa-plus me-2"></i>
                            إضافة طالب جديد
                        </a>
                        <a href="<?php echo e(route('admin.users.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-users me-2"></i>
                            جميع المستخدمين
                        </a>
                    </div>
                </div>
                
                <div class="card-body">
                    <!-- فلتر البحث -->
                    <div class="row mb-4">
                        <div class="col-md-6">
                            <form method="GET" action="<?php echo e(route('admin.users.students')); ?>" class="d-flex">
                                <input type="text" name="search" class="form-control me-2" 
                                       placeholder="البحث في اسم الطالب أو البريد الإلكتروني..." 
                                       value="<?php echo e(request('search')); ?>">
                                <button type="submit" class="btn btn-outline-primary">
                                    <i class="fas fa-search"></i>
                                </button>
                            </form>
                        </div>
                        <div class="col-md-6">
                            <div class="text-end">
                                <span class="badge bg-info fs-6">إجمالي الطلاب: <?php echo e($students->total()); ?></span>
                            </div>
                        </div>
                    </div>

                    <!-- جدول الطلاب -->
                    <div class="table-responsive">
                        <table class="table table-hover">
                            <thead class="table-light">
                                <tr>
                                    <th>الرقم</th>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>عدد الدروس</th>
                                    <th>الحضور</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__empty_1 = true; $__currentLoopData = $students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
                                <tr>
                                    <td><?php echo e($student->id); ?></td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-circle bg-info me-2">
                                                <?php echo e(substr($student->name, 0, 2)); ?>

                                            </div>
                                            <?php echo e($student->name); ?>

                                        </div>
                                    </td>
                                    <td><?php echo e($student->email); ?></td>
                                    <td>
                                        <span class="badge bg-primary"><?php echo e($student->lessons_count); ?> درس</span>
                                    </td>
                                    <td>
                                        <span class="badge bg-success"><?php echo e($student->attendances_count); ?> حضور</span>
                                    </td>
                                    <td><?php echo e($student->created_at->format('Y/m/d')); ?></td>
                                    <td>
                                        <div class="btn-group" role="group">
                                            <a href="<?php echo e(route('admin.users.show', $student)); ?>" 
                                               class="btn btn-sm btn-outline-primary" title="عرض">
                                                <i class="fas fa-eye"></i>
                                            </a>
                                            <a href="<?php echo e(route('admin.users.edit', $student)); ?>" 
                                               class="btn btn-sm btn-outline-warning" title="تعديل">
                                                <i class="fas fa-edit"></i>
                                            </a>
                                            <button type="button" class="btn btn-sm btn-outline-danger" 
                                                    title="حذف" onclick="confirmDelete(<?php echo e($student->id); ?>)">
                                                <i class="fas fa-trash"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
                                <tr>
                                    <td colspan="7" class="text-center text-muted py-4">
                                        <i class="fas fa-user-graduate fa-2x mb-3"></i>
                                        <p>لا يوجد طلاب</p>
                                        <a href="<?php echo e(route('admin.users.create')); ?>?role=student" class="btn btn-primary">
                                            إضافة طالب جديد
                                        </a>
                                    </td>
                                </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <!-- Pagination -->
                    <div class="d-flex justify-content-center">
                        <?php echo e($students->appends(request()->query())->links()); ?>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<!-- Modal تأكيد الحذف -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تأكيد حذف الطالب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                هل أنت متأكد من حذف هذا الطالب؟ سيتم حذف جميع سجلات الحضور المرتبطة به.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <form id="deleteForm" method="POST" style="display: inline;">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">حذف</button>
                </form>
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
    border-radius: 50%;
    display: flex;
    align-items: center;
    justify-content: center;
    font-weight: bold;
    font-size: 12px;
    text-transform: uppercase;
    color: white;
}
</style>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
function confirmDelete(studentId) {
    const deleteForm = document.getElementById('deleteForm');
    deleteForm.action = `<?php echo e(route('admin.users.index')); ?>/${studentId}`;
    
    const deleteModal = new bootstrap.Modal(document.getElementById('deleteModal'));
    deleteModal.show();
}
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\abdul\OneDrive\Documents\BasmahApp\resources\views/admin/users/students.blade.php ENDPATH**/ ?>