

<?php $__env->startSection('title', 'إدارة المكتبة والكتب'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .book-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .book-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .book-cover {
        width: 100%;
        height: 200px;
        object-fit: cover;
        background: linear-gradient(135deg, var(--islamic-teal), var(--islamic-gold));
    }
    .book-stats {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-top: 10px;
    }
    .stat-item {
        display: flex;
        align-items: center;
        font-size: 0.85rem;
        color: #6c757d;
    }
    .stat-item i {
        margin-left: 5px;
    }
    .filter-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="fas fa-book me-2 text-primary"></i>
            إدارة المكتبة والكتب
        </h1>
        <a href="<?php echo e(route('admin.books.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            إضافة كتاب جديد
        </a>
    </div>

    <!-- Search and Filter Section -->
    <div class="card filter-card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.books.index')); ?>" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">البحث</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" 
                               placeholder="البحث في العنوان أو المؤلف..."
                               value="<?php echo e(request('search')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">التصنيف</label>
                    <select name="category" class="form-select">
                        <option value="">جميع التصنيفات</option>
                        <option value="فقه" <?php echo e(request('category') === 'فقه' ? 'selected' : ''); ?>>فقه</option>
                        <option value="عقيدة" <?php echo e(request('category') === 'عقيدة' ? 'selected' : ''); ?>>عقيدة</option>
                        <option value="تفسير" <?php echo e(request('category') === 'تفسير' ? 'selected' : ''); ?>>تفسير</option>
                        <option value="حديث" <?php echo e(request('category') === 'حديث' ? 'selected' : ''); ?>>حديث</option>
                        <option value="سيرة" <?php echo e(request('category') === 'سيرة' ? 'selected' : ''); ?>>سيرة</option>
                        <option value="أخلاق" <?php echo e(request('category') === 'أخلاق' ? 'selected' : ''); ?>>أخلاق</option>
                        <option value="تاريخ" <?php echo e(request('category') === 'تاريخ' ? 'selected' : ''); ?>>تاريخ</option>
                        <option value="أدب" <?php echo e(request('category') === 'أدب' ? 'selected' : ''); ?>>أدب</option>
                    </select>
                </div>
                <div class="col-md-2">
                    <label class="form-label">الحالة</label>
                    <select name="status" class="form-select">
                        <option value="">جميع الحالات</option>
                        <option value="published" <?php echo e(request('status') === 'published' ? 'selected' : ''); ?>>منشور</option>
                        <option value="draft" <?php echo e(request('status') === 'draft' ? 'selected' : ''); ?>>مسودة</option>
                    </select>
                </div>
                <div class="col-md-3">
                    <label class="form-label">&nbsp;</label>
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-primary">
                            <i class="fas fa-search me-1"></i>بحث
                        </button>
                        <a href="<?php echo e(route('admin.books.index')); ?>" class="btn btn-outline-secondary">
                            <i class="fas fa-redo me-1"></i>إعادة تعيين
                        </a>
                    </div>
                </div>
            </form>
        </div>
    </div>

    <!-- Statistics Cards -->
    <div class="row mb-4">
        <div class="col-md-3">
            <div class="card stats-card text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-white-50 small">إجمالي الكتب</div>
                            <div class="h4 mb-0"><?php echo e($books->total()); ?></div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-book fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-success text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-white-50 small">الكتب المنشورة</div>
                            <div class="h4 mb-0"><?php echo e($books->where('is_published', true)->count()); ?></div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-check-circle fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-warning text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-white-50 small">الكتب المميزة</div>
                            <div class="h4 mb-0"><?php echo e($books->where('is_featured', true)->count()); ?></div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-star fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-3">
            <div class="card bg-info text-white">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div>
                            <div class="text-white-50 small">إجمالي التحميلات</div>
                            <div class="h4 mb-0"><?php echo e($books->sum('download_count')); ?></div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-download fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Books Grid -->
    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $books; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $book): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card book-card h-100">
                    <div class="position-relative">
                        <?php if($book->cover_image): ?>
                            <img src="<?php echo e(Storage::url($book->cover_image)); ?>" 
                                 alt="<?php echo e($book->title); ?>" 
                                 class="book-cover">
                        <?php else: ?>
                            <div class="book-cover d-flex align-items-center justify-content-center">
                                <i class="fas fa-book fa-3x text-white"></i>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Status Badges -->
                        <div class="position-absolute top-0 start-0 m-2">
                            <?php if($book->is_featured): ?>
                                <span class="badge bg-warning">
                                    <i class="fas fa-star me-1"></i>مميز
                                </span>
                            <?php endif; ?>
                            <?php if(!$book->is_published): ?>
                                <span class="badge bg-secondary">مسودة</span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Quick Actions -->
                        <div class="position-absolute top-0 end-0 m-2">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-light btn-sm" 
                                        onclick="toggleFeatured(<?php echo e($book->id); ?>)"
                                        title="تبديل المميز">
                                    <i class="fas fa-star <?php echo e($book->is_featured ? 'text-warning' : ''); ?>"></i>
                                </button>
                                <button class="btn btn-light btn-sm" 
                                        onclick="togglePublished(<?php echo e($book->id); ?>)"
                                        title="تبديل النشر">
                                    <i class="fas fa-eye <?php echo e($book->is_published ? 'text-success' : 'text-muted'); ?>"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo e(Str::limit($book->title, 50)); ?></h5>
                        <p class="text-muted mb-2">
                            <i class="fas fa-user me-1"></i><?php echo e($book->author); ?>

                        </p>
                        <p class="card-text flex-grow-1">
                            <?php echo e(Str::limit($book->description, 100)); ?>

                        </p>
                        
                        <!-- Category and Rating -->
                        <div class="mb-2">
                            <span class="badge bg-light text-dark"><?php echo e($book->category); ?></span>
                            <?php if($book->rating): ?>
                                <span class="text-warning ms-2">
                                    <?php for($i = 1; $i <= 5; $i++): ?>
                                        <i class="fas fa-star <?php echo e($i <= $book->rating ? '' : 'text-muted'); ?>"></i>
                                    <?php endfor; ?>
                                    <small class="text-muted">(<?php echo e($book->rating); ?>)</small>
                                </span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Stats -->
                        <div class="book-stats">
                            <div class="stat-item">
                                <i class="fas fa-download"></i>
                                <?php echo e($book->download_count); ?>

                            </div>
                            <div class="stat-item">
                                <i class="fas fa-file-pdf"></i>
                                <?php echo e($book->file_size ? number_format($book->file_size / 1024 / 1024, 1) . ' MB' : 'غير محدد'); ?>

                            </div>
                            <div class="stat-item">
                                <i class="fas fa-calendar"></i>
                                <?php echo e($book->created_at->format('Y/m/d')); ?>

                            </div>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="mt-3">
                            <div class="btn-group w-100">
                                <a href="<?php echo e(route('admin.books.show', $book)); ?>" 
                                   class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-eye me-1"></i>عرض
                                </a>
                                <a href="<?php echo e(route('admin.books.edit', $book)); ?>" 
                                   class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit me-1"></i>تعديل
                                </a>
                                <?php if($book->file_path): ?>
                                    <a href="<?php echo e(route('admin.books.download', $book)); ?>" 
                                       class="btn btn-outline-success btn-sm">
                                        <i class="fas fa-download me-1"></i>تحميل
                                    </a>
                                <?php endif; ?>
                                <button class="btn btn-outline-danger btn-sm" 
                                        onclick="deleteBook(<?php echo e($book->id); ?>)">
                                    <i class="fas fa-trash me-1"></i>حذف
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); if ($__empty_1): ?>
            <div class="col-12">
                <div class="card">
                    <div class="card-body text-center py-5">
                        <i class="fas fa-book fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">لا توجد كتب</h5>
                        <p class="text-muted">لم يتم العثور على أي كتب. قم بإضافة كتاب جديد للبدء.</p>
                        <a href="<?php echo e(route('admin.books.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>إضافة كتاب جديد
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($books->hasPages()): ?>
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($books->appends(request()->query())->links()); ?>

        </div>
    <?php endif; ?>
</div>

<!-- Delete Confirmation Modal -->
<div class="modal fade" id="deleteModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">تأكيد الحذف</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                هل أنت متأكد من حذف هذا الكتاب؟ هذا الإجراء لا يمكن التراجع عنه.
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <button type="button" class="btn btn-danger" id="confirmDelete">حذف</button>
            </div>
        </div>
    </div>
</div>
<?php $__env->stopSection(); ?>

<?php $__env->startPush('scripts'); ?>
<script>
let bookToDelete = null;

function deleteBook(id) {
    bookToDelete = id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (bookToDelete) {
        // Create and submit delete form
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/books/${bookToDelete}`;
        form.innerHTML = `
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
        `;
        document.body.appendChild(form);
        form.submit();
    }
});

function toggleFeatured(id) {
    fetch(`/admin/books/${id}/toggle-featured`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}

function togglePublished(id) {
    fetch(`/admin/books/${id}/toggle-published`, {
        method: 'POST',
        headers: {
            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
            'Content-Type': 'application/json',
        },
    })
    .then(response => response.json())
    .then(data => {
        if (data.success) {
            location.reload();
        }
    })
    .catch(error => console.error('Error:', error));
}
</script>
<?php $__env->stopPush(); ?>

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\osaid\BasmahApp\resources\views/admin/books/index.blade.php ENDPATH**/ ?>