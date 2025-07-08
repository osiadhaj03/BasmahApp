<?php $__env->startSection('title', 'إدارة طلاب الدرس'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">    <div>
        <h1 class="h3 mb-0">إدارة طلاب الدرس</h1>
        <p class="text-muted mb-0"><?php echo e($lesson->subject); ?> - <?php echo e($lesson->day_of_week); ?></p>
    </div>
    <div>
        <a href="<?php echo e(route('teacher.lessons.show', $lesson)); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-right"></i> العودة للدرس
        </a>
        <a href="<?php echo e(route('teacher.lessons.index')); ?>" class="btn btn-info">
            <i class="fas fa-list"></i> جميع الدروس
        </a>
    </div>
</div>

<div class="row">
    <!-- إحصائيات سريعة -->
    <div class="col-12 mb-4">
        <div class="row">
            <div class="col-md-3">
                <div class="card bg-primary text-white">
                    <div class="card-body text-center">
                        <h3 class="mb-0"><?php echo e($lesson->students()->count()); ?></h3>
                        <small>إجمالي الطلاب</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-success text-white">
                    <div class="card-body text-center">
                        <h3 class="mb-0"><?php echo e($lesson->max_students ?? '∞'); ?></h3>
                        <small>الحد الأقصى</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-warning text-dark">
                    <div class="card-body text-center">
                        <h3 class="mb-0"><?php echo e($lesson->max_students ? ($lesson->max_students - $lesson->students()->count()) : '∞'); ?></h3>
                        <small>مقاعد متاحة</small>
                    </div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card bg-info text-white">
                    <div class="card-body text-center">
                        <h3 class="mb-0"><?php echo e($averageAttendance); ?>%</h3>
                        <small>معدل الحضور</small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- إضافة طلاب جدد -->
    <div class="col-lg-4 mb-4">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-plus"></i>
                    إضافة طلاب جدد
                </h5>
            </div>
            <div class="card-body">
                <?php if($availableStudents->count() > 0): ?>
                    <form action="<?php echo e(route('teacher.lessons.add-student', $lesson)); ?>" method="POST">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="student_id" class="form-label">اختر الطالب</label>
                            <select class="form-select <?php $__errorArgs = ['student_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="student_id" 
                                    name="student_id" 
                                    required>
                                <option value="">اختر طالب...</option>
                                <?php $__currentLoopData = $availableStudents; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($student->id); ?>">
                                        <?php echo e($student->name); ?> (<?php echo e($student->email); ?>)
                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['student_id'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        </div>
                        
                        <button type="submit" class="btn btn-success w-100">
                            <i class="fas fa-plus"></i> إضافة الطالب
                        </button>
                    </form>
                <?php else: ?>
                    <div class="text-center text-muted">
                        <i class="fas fa-users fa-3x mb-3"></i>
                        <p>لا توجد طلاب متاحين للإضافة</p>
                        <small>جميع الطلاب مسجلين في هذا الدرس بالفعل</small>
                    </div>
                <?php endif; ?>
            </div>
        </div>

        <!-- إجراءات سريعة -->
        <div class="card mt-3">
            <div class="card-header bg-info text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-bolt"></i>
                    إجراءات سريعة
                </h5>
            </div>
            <div class="card-body">
                <a href="<?php echo e(route('teacher.attendances.lesson', $lesson)); ?>" class="btn btn-outline-primary w-100 mb-2">
                    <i class="fas fa-clipboard-check"></i> تسجيل الحضور
                </a>
                <a href="<?php echo e(route('teacher.lessons.edit', $lesson)); ?>" class="btn btn-outline-warning w-100 mb-2">
                    <i class="fas fa-edit"></i> تعديل الدرس
                </a>
                <button class="btn btn-outline-danger w-100" data-bs-toggle="modal" data-bs-target="#removeAllModal">
                    <i class="fas fa-user-minus"></i> إزالة جميع الطلاب
                </button>
            </div>
        </div>
    </div>

    <!-- قائمة الطلاب الحاليين -->
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                <h5 class="card-title mb-0">
                    <i class="fas fa-users"></i>
                    الطلاب المسجلين (<?php echo e($lesson->students()->count()); ?>)
                </h5>
                <div>
                    <button class="btn btn-light btn-sm" onclick="selectAllStudents()">
                        <i class="fas fa-check-square"></i> تحديد الكل
                    </button>
                    <button class="btn btn-light btn-sm" onclick="unselectAllStudents()">
                        <i class="fas fa-square"></i> إلغاء التحديد
                    </button>
                </div>
            </div>
            <div class="card-body p-0">
                <?php if($lesson->students()->count() > 0): ?>
                    <div class="table-responsive">
                        <table class="table table-hover mb-0">
                            <thead class="table-light">
                                <tr>
                                    <th width="50">
                                        <input type="checkbox" id="selectAll" onchange="toggleAllStudents()">
                                    </th>
                                    <th>الاسم</th>
                                    <th>البريد الإلكتروني</th>
                                    <th>تاريخ التسجيل</th>
                                    <th>معدل الحضور</th>
                                    <th width="120">الإجراءات</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $__currentLoopData = $lesson->students; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $student): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <tr>
                                    <td>
                                        <input type="checkbox" class="student-checkbox" value="<?php echo e($student->id); ?>">
                                    </td>
                                    <td>
                                        <div class="d-flex align-items-center">
                                            <div class="avatar-sm bg-primary text-white rounded-circle d-flex align-items-center justify-content-center me-2">
                                                <?php echo e(substr($student->name, 0, 1)); ?>

                                            </div>
                                            <strong><?php echo e($student->name); ?></strong>
                                        </div>
                                    </td>
                                    <td><?php echo e($student->email); ?></td>
                                    <td>
                                        <small class="text-muted"><?php echo e($student->pivot->created_at->format('Y/m/d')); ?></small>
                                    </td>
                                    <td>
                                        <?php
                                            $studentAttendanceRate = $studentAttendanceRates[$student->id] ?? 0;
                                        ?>
                                        <span class="badge <?php echo e($studentAttendanceRate >= 80 ? 'bg-success' : ($studentAttendanceRate >= 60 ? 'bg-warning' : 'bg-danger')); ?>">
                                            <?php echo e($studentAttendanceRate); ?>%
                                        </span>
                                    </td>
                                    <td>
                                        <div class="btn-group btn-group-sm">
                                            <a href="<?php echo e(route('teacher.attendances.student', [$lesson, $student])); ?>" 
                                               class="btn btn-outline-info" 
                                               title="عرض سجل الحضور">
                                                <i class="fas fa-history"></i>
                                            </a>
                                            <button class="btn btn-outline-danger" 
                                                    onclick="removeStudent(<?php echo e($student->id); ?>, '<?php echo e($student->name); ?>')"
                                                    title="إزالة من الدرس">
                                                <i class="fas fa-times"></i>
                                            </button>
                                        </div>
                                    </td>
                                </tr>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </tbody>
                        </table>
                    </div>
                    
                    <!-- إجراءات جماعية -->
                    <div class="p-3 bg-light border-top d-none" id="bulkActions">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="text-muted">
                                <span id="selectedCount">0</span> طالب محدد
                            </span>
                            <div>
                                <button class="btn btn-outline-danger btn-sm" onclick="removeSelectedStudents()">
                                    <i class="fas fa-user-minus"></i> إزالة المحددين
                                </button>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <div class="text-center py-5 text-muted">
                        <i class="fas fa-user-graduate fa-4x mb-3"></i>
                        <h5>لا توجد طلاب مسجلين</h5>
                        <p>ابدأ بإضافة طلاب إلى هذا الدرس</p>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- Modal لحذف طالب واحد -->
<div class="modal fade" id="removeStudentModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">إزالة طالب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد من إزالة الطالب <strong id="studentNameToRemove"></strong> من هذا الدرس؟</p>
                <small class="text-muted">سيتم حذف جميع سجلات الحضور المرتبطة بهذا الطالب في هذا الدرس.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <form id="removeStudentForm" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">نعم، أزل الطالب</button>
                </form>
            </div>
        </div>
    </div>
</div>

<!-- Modal لحذف جميع الطلاب -->
<div class="modal fade" id="removeAllModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header bg-danger text-white">
                <h5 class="modal-title">إزالة جميع الطلاب</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد من إزالة جميع الطلاب من هذا الدرس؟</p>
                <small class="text-muted">سيتم حذف جميع سجلات الحضور المرتبطة بهذا الدرس.</small>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <form action="<?php echo e(route('teacher.lessons.remove-all-students', $lesson)); ?>" method="POST" class="d-inline">
                    <?php echo csrf_field(); ?>
                    <?php echo method_field('DELETE'); ?>
                    <button type="submit" class="btn btn-danger">نعم، أزل جميع الطلاب</button>
                </form>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .avatar-sm {
        width: 32px;
        height: 32px;
        font-size: 14px;
    }
    .card {
        border: none;
        box-shadow: 0 0.125rem 0.25rem rgba(0, 0, 0, 0.075);
    }
    .table th {
        font-weight: 600;
        font-size: 0.875rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
function toggleAllStudents() {
    const selectAll = document.getElementById('selectAll');
    const checkboxes = document.querySelectorAll('.student-checkbox');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = selectAll.checked;
    });
    
    updateBulkActions();
}

function selectAllStudents() {
    const checkboxes = document.querySelectorAll('.student-checkbox');
    const selectAll = document.getElementById('selectAll');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = true;
    });
    selectAll.checked = true;
    
    updateBulkActions();
}

function unselectAllStudents() {
    const checkboxes = document.querySelectorAll('.student-checkbox');
    const selectAll = document.getElementById('selectAll');
    
    checkboxes.forEach(checkbox => {
        checkbox.checked = false;
    });
    selectAll.checked = false;
    
    updateBulkActions();
}

function updateBulkActions() {
    const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
    const bulkActions = document.getElementById('bulkActions');
    const selectedCount = document.getElementById('selectedCount');
    
    selectedCount.textContent = checkedBoxes.length;
    
    if (checkedBoxes.length > 0) {
        bulkActions.classList.remove('d-none');
    } else {
        bulkActions.classList.add('d-none');
    }
}

function removeStudent(studentId, studentName) {
    document.getElementById('studentNameToRemove').textContent = studentName;
    document.getElementById('removeStudentForm').action = 
        `<?php echo e(route('teacher.lessons.remove-student', [$lesson, '__STUDENT_ID__'])); ?>`.replace('__STUDENT_ID__', studentId);
    
    new bootstrap.Modal(document.getElementById('removeStudentModal')).show();
}

function removeSelectedStudents() {
    const checkedBoxes = document.querySelectorAll('.student-checkbox:checked');
    const studentIds = Array.from(checkedBoxes).map(cb => cb.value);
    
    if (studentIds.length === 0) {
        alert('يرجى تحديد طلاب للإزالة');
        return;
    }
    
    if (confirm(`هل أنت متأكد من إزالة ${studentIds.length} طالب من الدرس؟`)) {
        // إرسال طلب إزالة جماعية
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = '<?php echo e(route("teacher.lessons.remove-students", $lesson)); ?>';
        
        const csrfToken = document.createElement('input');
        csrfToken.type = 'hidden';
        csrfToken.name = '_token';
        csrfToken.value = '<?php echo e(csrf_token()); ?>';
        form.appendChild(csrfToken);
        
        const methodField = document.createElement('input');
        methodField.type = 'hidden';
        methodField.name = '_method';
        methodField.value = 'DELETE';
        form.appendChild(methodField);
        
        studentIds.forEach(id => {
            const input = document.createElement('input');
            input.type = 'hidden';
            input.name = 'student_ids[]';
            input.value = id;
            form.appendChild(input);
        });
        
        document.body.appendChild(form);
        form.submit();
    }
}

// إضافة مستمعات الأحداث للـ checkboxes
document.addEventListener('DOMContentLoaded', function() {
    const checkboxes = document.querySelectorAll('.student-checkbox');
    checkboxes.forEach(checkbox => {
        checkbox.addEventListener('change', updateBulkActions);
    });
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH /home/u994369532/basmah/resources/views/teacher/lessons/manage-students.blade.php ENDPATH**/ ?>