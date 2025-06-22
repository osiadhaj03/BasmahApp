

<?php $__env->startSection('title', 'إضافة درس جديد'); ?>

<?php $__env->startSection('content'); ?>
<div class="d-flex justify-content-between align-items-center mb-4">
    <div>
        <h1 class="h3 mb-0">إضافة درس جديد</h1>
        <p class="text-muted mb-0">إنشاء درس جديد وإضافته لجدولك</p>
    </div>
    <div>
        <a href="<?php echo e(route('teacher.lessons.index')); ?>" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-left"></i> العودة للدروس
        </a>
    </div>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header bg-success text-white">
                <h5 class="card-title mb-0">
                    <i class="fas fa-plus-circle"></i>
                    معلومات الدرس الجديد
                </h5>
            </div>
            <div class="card-body">
                <form action="<?php echo e(route('teacher.lessons.store')); ?>" method="POST">
                    <?php echo csrf_field(); ?>
                      <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="subject" class="form-label">المادة <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="subject" 
                                   name="subject" 
                                   value="<?php echo e(old('subject')); ?>"
                                   placeholder="اكتب اسم المادة (مثال: الرياضيات، العلوم...)"
                                   required
                                   list="subjects-list">
                            
                            <!-- قائمة المواد المقترحة -->
                            <datalist id="subjects-list">
                                <?php $__currentLoopData = $subjects; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $subject): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($subject); ?>">
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </datalist>
                            
                            <?php $__errorArgs = ['subject'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            <small class="form-text text-muted">يمكنك كتابة أي مادة تريدها</small>
                        </div>
                    </div>

                    <div class="row">
                        <div class="col-md-4 mb-3">
                            <label for="day_of_week" class="form-label">يوم الأسبوع <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['day_of_week'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="day_of_week" 
                                    name="day_of_week" 
                                    required>
                                <option value="">اختر اليوم</option>
                                <?php $__currentLoopData = $daysOfWeek; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $value => $label): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                    <option value="<?php echo e($value); ?>" <?php echo e(old('day_of_week') === $value ? 'selected' : ''); ?>>
                                        <?php echo e($label); ?>

                                    </option>
                                <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                            </select>
                            <?php $__errorArgs = ['day_of_week'];
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

                        <div class="col-md-4 mb-3">
                            <label for="start_time" class="form-label">وقت البداية <span class="text-danger">*</span></label>
                            <input type="time" 
                                   class="form-control <?php $__errorArgs = ['start_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="start_time" 
                                   name="start_time" 
                                   value="<?php echo e(old('start_time')); ?>" 
                                   required>
                            <?php $__errorArgs = ['start_time'];
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

                        <div class="col-md-4 mb-3">
                            <label for="end_time" class="form-label">وقت النهاية <span class="text-danger">*</span></label>
                            <input type="time" 
                                   class="form-control <?php $__errorArgs = ['end_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="end_time" 
                                   name="end_time" 
                                   value="<?php echo e(old('end_time')); ?>" 
                                   required>
                            <?php $__errorArgs = ['end_time'];
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
                    </div>

                    <div class="mb-3">
                        <label for="description" class="form-label">وصف الدرس</label>
                        <textarea class="form-control <?php $__errorArgs = ['description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="description" 
                                  name="description" 
                                  rows="4" 
                                  placeholder="وصف مختصر عن محتوى الدرس والأهداف..."><?php echo e(old('description')); ?></textarea>
                        <?php $__errorArgs = ['description'];
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

                    <?php $__errorArgs = ['time_conflict'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                        <div class="alert alert-danger">
                            <i class="fas fa-exclamation-triangle me-2"></i>
                            <?php echo e($message); ?>

                        </div>
                    <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>

                    <div class="d-flex justify-content-between">
                        <a href="<?php echo e(route('teacher.lessons.index')); ?>" class="btn btn-secondary">
                            <i class="fas fa-times"></i> إلغاء
                        </a>
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save"></i> حفظ الدرس
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>

    <div class="col-lg-4">
        <!-- معاينة الجدول -->
        <div class="card">
            <div class="card-header bg-light">
                <h6 class="card-title mb-0">
                    <i class="fas fa-calendar"></i>
                    دروسي الحالية
                </h6>
            </div>
            <div class="card-body">
                <?php
                    $currentLessons = \App\Models\Lesson::where('teacher_id', $teacher->id)
                        ->orderBy('day_of_week')
                        ->orderBy('start_time')
                        ->limit(5)
                        ->get();
                ?>
                
                <?php if($currentLessons->count() > 0): ?>
                    <?php $__currentLoopData = $currentLessons; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $lesson): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                    <div class="d-flex justify-content-between align-items-center mb-2 p-2 border rounded">
                        <div>
                            <small class="fw-bold"><?php echo e($lesson->subject); ?></small>
                            <?php if($lesson->day_of_week && $lesson->start_time): ?>
                            <br>
                            <small class="text-muted">
                                <?php echo e(ucfirst($lesson->day_of_week)); ?> - 
                                <?php echo e(\Carbon\Carbon::parse($lesson->start_time)->format('H:i')); ?>

                            </small>
                            <?php endif; ?>
                        </div>
                        <span class="badge bg-primary"><?php echo e($lesson->students_count); ?> طالب</span>
                    </div>
                    <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                <?php else: ?>
                    <p class="text-muted mb-0">لا توجد دروس مسجلة بعد</p>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startSection('scripts'); ?>
<script>
document.addEventListener('DOMContentLoaded', function() {
    // التحقق من تعارض الأوقات
    const daySelect = document.getElementById('day_of_week');
    const startTimeInput = document.getElementById('start_time');
    const endTimeInput = document.getElementById('end_time');
    
    function checkTimeConflict() {
        if (daySelect.value && startTimeInput.value && endTimeInput.value) {
            // يمكن إضافة AJAX call للتحقق من التعارض
            console.log('Checking time conflict...');
        }
    }
    
    daySelect.addEventListener('change', checkTimeConflict);
    startTimeInput.addEventListener('change', checkTimeConflict);
    endTimeInput.addEventListener('change', checkTimeConflict);
    
    // التحقق من أن وقت النهاية بعد وقت البداية
    function validateTimes() {
        if (startTimeInput.value && endTimeInput.value) {
            if (endTimeInput.value <= startTimeInput.value) {
                endTimeInput.setCustomValidity('وقت النهاية يجب أن يكون بعد وقت البداية');
            } else {
                endTimeInput.setCustomValidity('');
            }
        }
    }
    
    startTimeInput.addEventListener('change', validateTimes);
    endTimeInput.addEventListener('change', validateTimes);
    
    // التركيز على حقل المادة
    document.getElementById('subject').focus();
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\abdul\OneDrive\Documents\BasmahApp\resources\views/teacher/lessons/create.blade.php ENDPATH**/ ?>