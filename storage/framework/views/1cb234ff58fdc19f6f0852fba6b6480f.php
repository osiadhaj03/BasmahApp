

<?php $__env->startSection('title', 'إضافة مقال جديد'); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0 text-primary">
                <i class="fas fa-plus-circle me-2"></i>
                إضافة مقال جديد
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.dashboard')); ?>">لوحة التحكم</a></li>
                    <li class="breadcrumb-item"><a href="<?php echo e(route('admin.articles.index')); ?>">المقالات</a></li>
                    <li class="breadcrumb-item active">إضافة مقال جديد</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">تفاصيل المقال</h5>
                </div>
                <div class="card-body">
                    <form action="<?php echo e(route('admin.articles.store')); ?>" method="POST" enctype="multipart/form-data">
                        <?php echo csrf_field(); ?>
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label">
                                    عنوان المقال <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="title" 
                                       name="title" 
                                       value="<?php echo e(old('title')); ?>" 
                                       required>
                                <?php $__errorArgs = ['title'];
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

                            <div class="col-md-6 mb-3">
                                <label for="slug" class="form-label">الرابط (اختياري)</label>
                                <input type="text" 
                                       class="form-control <?php $__errorArgs = ['slug'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="slug" 
                                       name="slug" 
                                       value="<?php echo e(old('slug')); ?>"
                                       placeholder="سيتم إنشاؤه تلقائياً من العنوان">
                                <?php $__errorArgs = ['slug'];
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

                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">التصنيف</label>
                                <select class="form-select <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" id="category" name="category">
                                    <option value="">اختر التصنيف</option>
                                    <option value="القرآن الكريم" <?php echo e(old('category') == 'القرآن الكريم' ? 'selected' : ''); ?>>القرآن الكريم</option>
                                    <option value="الحديث الشريف" <?php echo e(old('category') == 'الحديث الشريف' ? 'selected' : ''); ?>>الحديث الشريف</option>
                                    <option value="العقيدة" <?php echo e(old('category') == 'العقيدة' ? 'selected' : ''); ?>>العقيدة</option>
                                    <option value="الفقه" <?php echo e(old('category') == 'الفقه' ? 'selected' : ''); ?>>الفقه</option>
                                    <option value="السيرة النبوية" <?php echo e(old('category') == 'السيرة النبوية' ? 'selected' : ''); ?>>السيرة النبوية</option>
                                    <option value="التاريخ الإسلامي" <?php echo e(old('category') == 'التاريخ الإسلامي' ? 'selected' : ''); ?>>التاريخ الإسلامي</option>
                                    <option value="الأخلاق والآداب" <?php echo e(old('category') == 'الأخلاق والآداب' ? 'selected' : ''); ?>>الأخلاق والآداب</option>
                                    <option value="أخرى" <?php echo e(old('category') == 'أخرى' ? 'selected' : ''); ?>>أخرى</option>
                                </select>
                                <?php $__errorArgs = ['category'];
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

                            <div class="col-md-12 mb-3">
                                <label for="excerpt" class="form-label">مقتطف قصير</label>
                                <textarea class="form-control <?php $__errorArgs = ['excerpt'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          id="excerpt" 
                                          name="excerpt" 
                                          rows="3" 
                                          placeholder="مقتطف قصير يلخص محتوى المقال"><?php echo e(old('excerpt')); ?></textarea>
                                <?php $__errorArgs = ['excerpt'];
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

                            <div class="col-md-12 mb-3">
                                <label for="content" class="form-label">
                                    محتوى المقال <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control <?php $__errorArgs = ['content'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                          id="content" 
                                          name="content" 
                                          rows="12" 
                                          required><?php echo e(old('content')); ?></textarea>
                                <?php $__errorArgs = ['content'];
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

                            <div class="col-md-6 mb-3">
                                <label for="reading_time" class="form-label">وقت القراءة (بالدقائق)</label>
                                <input type="number" 
                                       class="form-control <?php $__errorArgs = ['reading_time'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="reading_time" 
                                       name="reading_time" 
                                       value="<?php echo e(old('reading_time')); ?>"
                                       min="1"
                                       placeholder="سيتم حسابه تلقائياً">
                                <?php $__errorArgs = ['reading_time'];
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

                            <div class="col-md-6 mb-3">
                                <label for="featured_image" class="form-label">الصورة المميزة</label>
                                <input type="file" 
                                       class="form-control <?php $__errorArgs = ['featured_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="featured_image" 
                                       name="featured_image" 
                                       accept="image/*">
                                <?php $__errorArgs = ['featured_image'];
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

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="<?php echo e(route('admin.articles.index')); ?>" class="btn btn-secondary">
                                        <i class="fas fa-arrow-right me-2"></i>
                                        العودة
                                    </a>
                                    <div>
                                        <button type="submit" name="action" value="draft" class="btn btn-outline-primary me-2">
                                            <i class="fas fa-save me-2"></i>
                                            حفظ كمسودة
                                        </button>
                                        <button type="submit" name="action" value="publish" class="btn btn-success">
                                            <i class="fas fa-paper-plane me-2"></i>
                                            نشر المقال
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- SEO Settings -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-success text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-search me-2"></i>
                        إعدادات محرك البحث (SEO)
                    </h6>
                </div>
                <div class="card-body">
                    <div class="mb-3">
                        <label for="meta_title" class="form-label">العنوان في محرك البحث</label>
                        <input type="text" 
                               class="form-control <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="meta_title" 
                               name="meta_title" 
                               value="<?php echo e(old('meta_title')); ?>"
                               maxlength="60">
                        <?php $__errorArgs = ['meta_title'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">الحد الأقصى 60 حرف</small>
                    </div>

                    <div class="mb-3">
                        <label for="meta_description" class="form-label">الوصف في محرك البحث</label>
                        <textarea class="form-control <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                  id="meta_description" 
                                  name="meta_description" 
                                  rows="3"
                                  maxlength="160"><?php echo e(old('meta_description')); ?></textarea>
                        <?php $__errorArgs = ['meta_description'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">الحد الأقصى 160 حرف</small>
                    </div>

                    <div class="mb-3">
                        <label for="meta_keywords" class="form-label">الكلمات المفتاحية</label>
                        <input type="text" 
                               class="form-control <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="meta_keywords" 
                               name="meta_keywords" 
                               value="<?php echo e(old('meta_keywords')); ?>"
                               placeholder="كلمة1, كلمة2, كلمة3">
                        <?php $__errorArgs = ['meta_keywords'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">افصل بين الكلمات بفاصلة</small>
                    </div>
                </div>
            </div>

            <!-- Article Settings -->
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        إعدادات المقال
                    </h6>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_featured" 
                               name="is_featured" 
                               value="1" 
                               <?php echo e(old('is_featured') ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="is_featured">
                            <i class="fas fa-star text-warning me-1"></i>
                            مقال مميز
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="allow_comments" 
                               name="allow_comments" 
                               value="1" 
                               <?php echo e(old('allow_comments', true) ? 'checked' : ''); ?>>
                        <label class="form-check-label" for="allow_comments">
                            <i class="fas fa-comments text-primary me-1"></i>
                            السماح بالتعليقات
                        </label>
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">العلامات</label>
                        <input type="text" 
                               class="form-control <?php $__errorArgs = ['tags'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                               id="tags" 
                               name="tags" 
                               value="<?php echo e(old('tags')); ?>"
                               placeholder="علامة1, علامة2, علامة3">
                        <?php $__errorArgs = ['tags'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                            <div class="invalid-feedback"><?php echo e($message); ?></div>
                        <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                        <small class="text-muted">افصل بين العلامات بفاصلة</small>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-generate slug from title
    const titleInput = document.getElementById('title');
    const slugInput = document.getElementById('slug');
    
    titleInput.addEventListener('input', function() {
        if (!slugInput.value) {
            const slug = this.value
                .toLowerCase()
                .replace(/[^a-z0-9\u0600-\u06FF\s-]/g, '')
                .replace(/\s+/g, '-')
                .replace(/-+/g, '-')
                .trim('-');
            slugInput.value = slug;
        }
    });

    // Auto-calculate reading time
    const contentTextarea = document.getElementById('content');
    const readingTimeInput = document.getElementById('reading_time');
    
    contentTextarea.addEventListener('input', function() {
        if (!readingTimeInput.value) {
            const wordCount = this.value.trim().split(/\s+/).length;
            const readingTime = Math.ceil(wordCount / 200); // 200 words per minute
            readingTimeInput.value = readingTime;
        }
    });
});
</script>
<?php $__env->stopSection(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\osaid\BasmahApp\resources\views/admin/articles/create.blade.php ENDPATH**/ ?>