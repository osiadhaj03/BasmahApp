

<?php $__env->startSection('title', isset($book) ? 'تعديل الكتاب' : 'إضافة كتاب جديد'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .form-section {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(212, 168, 83, 0.2);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .section-title {
        color: var(--islamic-teal);
        border-bottom: 2px solid var(--islamic-gold);
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: 600;
    }
    .form-control:focus {
        border-color: var(--islamic-gold);
        box-shadow: 0 0 0 0.2rem rgba(212, 168, 83, 0.25);
    }
    .cover-preview {
        max-width: 200px;
        max-height: 250px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .file-info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        border: 2px dashed #dee2e6;
    }
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: var(--islamic-gold);
    }
    input:checked + .slider:before {
        transform: translateX(26px);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="fas fa-book me-2 text-primary"></i>
            <?php echo e(isset($book) ? 'تعديل الكتاب' : 'إضافة كتاب جديد'); ?>

        </h1>
        <a href="<?php echo e(route('admin.books.index')); ?>" class="btn btn-secondary">
            <i class="fas fa-arrow-right me-2"></i>العودة للقائمة
        </a>
    </div>

    <form action="<?php echo e(isset($book) ? route('admin.books.update', $book) : route('admin.books.store')); ?>" 
          method="POST" 
          enctype="multipart/form-data">
        <?php echo csrf_field(); ?>
        <?php if(isset($book)): ?>
            <?php echo method_field('PUT'); ?>
        <?php endif; ?>

        <div class="row">
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-info-circle me-2"></i>المعلومات الأساسية
                    </h4>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="title" class="form-label">عنوان الكتاب <span class="text-danger">*</span></label>
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
                                   value="<?php echo e(old('title', $book->title ?? '')); ?>" 
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
                            <label for="author" class="form-label">المؤلف <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['author'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="author" 
                                   name="author" 
                                   value="<?php echo e(old('author', $book->author ?? '')); ?>" 
                                   required>
                            <?php $__errorArgs = ['author'];
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
                            <label for="isbn" class="form-label">رقم ISBN</label>
                            <input type="text" 
                                   class="form-control <?php $__errorArgs = ['isbn'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="isbn" 
                                   name="isbn" 
                                   value="<?php echo e(old('isbn', $book->isbn ?? '')); ?>">
                            <?php $__errorArgs = ['isbn'];
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
                            <label for="category" class="form-label">التصنيف <span class="text-danger">*</span></label>
                            <select class="form-select <?php $__errorArgs = ['category'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="category" 
                                    name="category" 
                                    required>
                                <option value="">اختر التصنيف</option>
                                <option value="فقه" <?php echo e(old('category', $book->category ?? '') === 'فقه' ? 'selected' : ''); ?>>فقه</option>
                                <option value="عقيدة" <?php echo e(old('category', $book->category ?? '') === 'عقيدة' ? 'selected' : ''); ?>>عقيدة</option>
                                <option value="تفسير" <?php echo e(old('category', $book->category ?? '') === 'تفسير' ? 'selected' : ''); ?>>تفسير</option>
                                <option value="حديث" <?php echo e(old('category', $book->category ?? '') === 'حديث' ? 'selected' : ''); ?>>حديث</option>
                                <option value="سيرة" <?php echo e(old('category', $book->category ?? '') === 'سيرة' ? 'selected' : ''); ?>>سيرة</option>
                                <option value="أخلاق" <?php echo e(old('category', $book->category ?? '') === 'أخلاق' ? 'selected' : ''); ?>>أخلاق</option>
                                <option value="تاريخ" <?php echo e(old('category', $book->category ?? '') === 'تاريخ' ? 'selected' : ''); ?>>تاريخ</option>
                                <option value="أدب" <?php echo e(old('category', $book->category ?? '') === 'أدب' ? 'selected' : ''); ?>>أدب</option>
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
                        
                        <div class="col-md-6 mb-3">
                            <label for="language" class="form-label">اللغة</label>
                            <select class="form-select <?php $__errorArgs = ['language'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                    id="language" 
                                    name="language">
                                <option value="العربية" <?php echo e(old('language', $book->language ?? 'العربية') === 'العربية' ? 'selected' : ''); ?>>العربية</option>
                                <option value="الإنجليزية" <?php echo e(old('language', $book->language ?? '') === 'الإنجليزية' ? 'selected' : ''); ?>>الإنجليزية</option>
                                <option value="الفرنسية" <?php echo e(old('language', $book->language ?? '') === 'الفرنسية' ? 'selected' : ''); ?>>الفرنسية</option>
                                <option value="أخرى" <?php echo e(old('language', $book->language ?? '') === 'أخرى' ? 'selected' : ''); ?>>أخرى</option>
                            </select>
                            <?php $__errorArgs = ['language'];
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
                            <label for="publication_year" class="form-label">سنة النشر</label>
                            <input type="number" 
                                   class="form-control <?php $__errorArgs = ['publication_year'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="publication_year" 
                                   name="publication_year" 
                                   value="<?php echo e(old('publication_year', $book->publication_year ?? '')); ?>"
                                   min="1400" 
                                   max="<?php echo e(date('Y')); ?>">
                            <?php $__errorArgs = ['publication_year'];
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
                            <label for="pages_count" class="form-label">عدد الصفحات</label>
                            <input type="number" 
                                   class="form-control <?php $__errorArgs = ['pages_count'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="pages_count" 
                                   name="pages_count" 
                                   value="<?php echo e(old('pages_count', $book->pages_count ?? '')); ?>"
                                   min="1">
                            <?php $__errorArgs = ['pages_count'];
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
                        
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">وصف الكتاب <span class="text-danger">*</span></label>
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
                                      required><?php echo e(old('description', $book->description ?? '')); ?></textarea>
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
                    </div>
                </div>

                <!-- Files Section -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-file me-2"></i>الملفات والمرفقات
                    </h4>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cover_image" class="form-label">غلاف الكتاب</label>
                            <input type="file" 
                                   class="form-control <?php $__errorArgs = ['cover_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="cover_image" 
                                   name="cover_image" 
                                   accept="image/*">
                            <small class="form-text text-muted">
                                الصيغ المدعومة: JPG, PNG, GIF. الحد الأقصى: 2MB
                            </small>
                            <?php $__errorArgs = ['cover_image'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            
                            <?php if(isset($book) && $book->cover_image): ?>
                                <div class="mt-2">
                                    <img src="<?php echo e(Storage::url($book->cover_image)); ?>" 
                                         alt="غلاف الكتاب الحالي" 
                                         class="cover-preview">
                                    <p class="text-muted mt-1">الغلاف الحالي</p>
                                </div>
                            <?php endif; ?>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="book_file" class="form-label">ملف الكتاب</label>
                            <input type="file" 
                                   class="form-control <?php $__errorArgs = ['book_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                   id="book_file" 
                                   name="book_file" 
                                   accept=".pdf,.doc,.docx,.epub">
                            <small class="form-text text-muted">
                                الصيغ المدعومة: PDF, DOC, DOCX, EPUB. الحد الأقصى: 50MB
                            </small>
                            <?php $__errorArgs = ['book_file'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?>
                                <div class="invalid-feedback"><?php echo e($message); ?></div>
                            <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>
                            
                            <?php if(isset($book) && $book->file_path): ?>
                                <div class="file-info mt-2">
                                    <i class="fas fa-file-pdf text-danger me-2"></i>
                                    <strong>ملف موجود:</strong> <?php echo e(basename($book->file_path)); ?>

                                    <br>
                                    <small class="text-muted">
                                        الحجم: <?php echo e($book->file_size ? number_format($book->file_size / 1024 / 1024, 1) . ' MB' : 'غير محدد'); ?>

                                    </small>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <!-- SEO and Tags -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-tags me-2"></i>العلامات والكلمات المفتاحية
                    </h4>
                    
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="tags" class="form-label">الكلمات المفتاحية</label>
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
                                   value="<?php echo e(old('tags', isset($book) && $book->tags ? implode(', ', $book->tags) : '')); ?>"
                                   placeholder="أدخل الكلمات المفتاحية مفصولة بفواصل">
                            <small class="form-text text-muted">
                                مثال: فقه, عبادات, صلاة, زكاة
                            </small>
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
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Publishing Options -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-cog me-2"></i>خيارات النشر
                    </h4>
                    
                    <div class="mb-3">
                        <label class="form-label d-flex align-items-center">
                            <span class="me-3">كتاب مميز</span>
                            <label class="switch">
                                <input type="checkbox" 
                                       name="is_featured" 
                                       value="1" 
                                       <?php echo e(old('is_featured', $book->is_featured ?? false) ? 'checked' : ''); ?>>
                                <span class="slider"></span>
                            </label>
                        </label>
                        <small class="form-text text-muted">
                            الكتب المميزة تظهر في المقدمة
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label d-flex align-items-center">
                            <span class="me-3">منشور</span>
                            <label class="switch">
                                <input type="checkbox" 
                                       name="is_published" 
                                       value="1" 
                                       <?php echo e(old('is_published', $book->is_published ?? true) ? 'checked' : ''); ?>>
                                <span class="slider"></span>
                            </label>
                        </label>
                        <small class="form-text text-muted">
                            غير المنشور لا يظهر للزوار
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label d-flex align-items-center">
                            <span class="me-3">قابل للتحميل</span>
                            <label class="switch">
                                <input type="checkbox" 
                                       name="is_downloadable" 
                                       value="1" 
                                       <?php echo e(old('is_downloadable', $book->is_downloadable ?? true) ? 'checked' : ''); ?>>
                                <span class="slider"></span>
                            </label>
                        </label>
                        <small class="form-text text-muted">
                            السماح بتحميل الكتاب
                        </small>
                    </div>
                </div>

                <!-- Rating Section -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-star me-2"></i>التقييم
                    </h4>
                    
                    <div class="mb-3">
                        <label for="rating" class="form-label">تقييم الكتاب</label>
                        <select class="form-select <?php $__errorArgs = ['rating'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                id="rating" 
                                name="rating">
                            <option value="">بدون تقييم</option>
                            <option value="1" <?php echo e(old('rating', $book->rating ?? '') == '1' ? 'selected' : ''); ?>>⭐ (1)</option>
                            <option value="2" <?php echo e(old('rating', $book->rating ?? '') == '2' ? 'selected' : ''); ?>>⭐⭐ (2)</option>
                            <option value="3" <?php echo e(old('rating', $book->rating ?? '') == '3' ? 'selected' : ''); ?>>⭐⭐⭐ (3)</option>
                            <option value="4" <?php echo e(old('rating', $book->rating ?? '') == '4' ? 'selected' : ''); ?>>⭐⭐⭐⭐ (4)</option>
                            <option value="5" <?php echo e(old('rating', $book->rating ?? '') == '5' ? 'selected' : ''); ?>>⭐⭐⭐⭐⭐ (5)</option>
                        </select>
                        <?php $__errorArgs = ['rating'];
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

                <!-- Statistics (for edit only) -->
                <?php if(isset($book)): ?>
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-chart-bar me-2"></i>الإحصائيات
                    </h4>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h4 text-primary"><?php echo e($book->download_count); ?></div>
                                <small class="text-muted">تحميلات</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h4 text-success"><?php echo e($book->created_at->diffForHumans()); ?></div>
                                <small class="text-muted">تاريخ الإضافة</small>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endif; ?>

                <!-- Action Buttons -->
                <div class="form-section">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>
                            <?php echo e(isset($book) ? 'تحديث الكتاب' : 'حفظ الكتاب'); ?>

                        </button>
                        
                        <?php if(isset($book)): ?>
                            <a href="<?php echo e(route('admin.books.show', $book)); ?>" class="btn btn-outline-info">
                                <i class="fas fa-eye me-2"></i>معاينة الكتاب
                            </a>
                        <?php endif; ?>
                        
                        <a href="<?php echo e(route('admin.books.index')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>إلغاء
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
// File size validation
document.getElementById('book_file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const maxSize = 50 * 1024 * 1024; // 50MB
    
    if (file && file.size > maxSize) {
        alert('حجم الملف كبير جداً. الحد الأقصى المسموح 50 ميجابايت.');
        this.value = '';
    }
});

document.getElementById('cover_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const maxSize = 2 * 1024 * 1024; // 2MB
    
    if (file && file.size > maxSize) {
        alert('حجم الصورة كبير جداً. الحد الأقصى المسموح 2 ميجابايت.');
        this.value = '';
    }
});

// Auto-slug generation
document.getElementById('title').addEventListener('input', function(e) {
    // You can add auto-slug generation here if needed
});
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\osaid\BasmahApp\resources\views/admin/books/create.blade.php ENDPATH**/ ?>