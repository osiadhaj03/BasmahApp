

<?php $__env->startSection('title', 'إدارة المقالات'); ?>

<?php $__env->startPush('styles'); ?>
<style>
    .article-card {
        transition: all 0.3s ease;
        border: none;
        border-radius: 15px;
        overflow: hidden;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
        height: 100%;
    }
    .article-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 8px 25px rgba(0,0,0,0.15);
    }
    .article-image {
        width: 100%;
        height: 180px;
        object-fit: cover;
        background: linear-gradient(135deg, var(--islamic-teal), var(--islamic-gold));
    }
    .article-meta {
        display: flex;
        align-items: center;
        gap: 15px;
        margin-top: 10px;
        font-size: 0.85rem;
        color: #6c757d;
    }
    .meta-item {
        display: flex;
        align-items: center;
        gap: 5px;
    }
    .filter-card {
        background: linear-gradient(135deg, #f8f9fa 0%, #e9ecef 100%);
        border: none;
        border-radius: 15px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.1);
    }
    .status-badge {
        font-size: 0.75rem;
        padding: 4px 8px;
    }
    .reading-time {
        background: var(--islamic-gold);
        color: white;
        padding: 2px 8px;
        border-radius: 10px;
        font-size: 0.75rem;
    }
</style>
<?php $__env->stopPush(); ?>

<?php $__env->startSection('content'); ?>
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="fas fa-newspaper me-2 text-primary"></i>
            إدارة المقالات
        </h1>
        <a href="<?php echo e(route('admin.articles.create')); ?>" class="btn btn-primary">
            <i class="fas fa-plus me-2"></i>
            إضافة مقال جديد
        </a>
    </div>

    <!-- Search and Filter Section -->
    <div class="card filter-card mb-4">
        <div class="card-body">
            <form method="GET" action="<?php echo e(route('admin.articles.index')); ?>" class="row g-3">
                <div class="col-md-4">
                    <label class="form-label">البحث</label>
                    <div class="input-group">
                        <span class="input-group-text"><i class="fas fa-search"></i></span>
                        <input type="text" name="search" class="form-control" 
                               placeholder="البحث في العنوان أو المحتوى..."
                               value="<?php echo e(request('search')); ?>">
                    </div>
                </div>
                <div class="col-md-3">
                    <label class="form-label">التصنيف</label>
                    <select name="category" class="form-select">
                        <option value="">جميع التصنيفات</option>
                        <option value="إسلاميات" <?php echo e(request('category') === 'إسلاميات' ? 'selected' : ''); ?>>إسلاميات</option>
                        <option value="فقه" <?php echo e(request('category') === 'فقه' ? 'selected' : ''); ?>>فقه</option>
                        <option value="عقيدة" <?php echo e(request('category') === 'عقيدة' ? 'selected' : ''); ?>>عقيدة</option>
                        <option value="تفسير" <?php echo e(request('category') === 'تفسير' ? 'selected' : ''); ?>>تفسير</option>
                        <option value="حديث" <?php echo e(request('category') === 'حديث' ? 'selected' : ''); ?>>حديث</option>
                        <option value="سيرة" <?php echo e(request('category') === 'سيرة' ? 'selected' : ''); ?>>سيرة</option>
                        <option value="أخلاق" <?php echo e(request('category') === 'أخلاق' ? 'selected' : ''); ?>>أخلاق</option>
                        <option value="دعوة" <?php echo e(request('category') === 'دعوة' ? 'selected' : ''); ?>>دعوة</option>
                        <option value="تربية" <?php echo e(request('category') === 'تربية' ? 'selected' : ''); ?>>تربية</option>
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
                        <a href="<?php echo e(route('admin.articles.index')); ?>" class="btn btn-outline-secondary">
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
                            <div class="text-white-50 small">إجمالي المقالات</div>
                            <div class="h4 mb-0"><?php echo e($articles->total()); ?></div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-newspaper fa-2x text-white-50"></i>
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
                            <div class="text-white-50 small">المقالات المنشورة</div>
                            <div class="h4 mb-0"><?php echo e($articles->where('is_published', true)->count()); ?></div>
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
                            <div class="text-white-50 small">المقالات المميزة</div>
                            <div class="h4 mb-0"><?php echo e($articles->where('is_featured', true)->count()); ?></div>
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
                            <div class="text-white-50 small">إجمالي المشاهدات</div>
                            <div class="h4 mb-0"><?php echo e($articles->sum('views_count')); ?></div>
                        </div>
                        <div class="align-self-center">
                            <i class="fas fa-eye fa-2x text-white-50"></i>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Articles Grid -->
    <div class="row">
        <?php $__empty_1 = true; $__currentLoopData = $articles; $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $article): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); $__empty_1 = false; ?>
            <div class="col-lg-4 col-md-6 mb-4">
                <div class="card article-card">
                    <div class="position-relative">
                        <?php if($article->featured_image): ?>
                            <img src="<?php echo e(Storage::url($article->featured_image)); ?>" 
                                 alt="<?php echo e($article->title); ?>" 
                                 class="article-image">
                        <?php else: ?>
                            <div class="article-image d-flex align-items-center justify-content-center">
                                <i class="fas fa-newspaper fa-3x text-white"></i>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Status Badges -->
                        <div class="position-absolute top-0 start-0 m-2">
                            <?php if($article->is_featured): ?>
                                <span class="badge bg-warning status-badge">
                                    <i class="fas fa-star me-1"></i>مميز
                                </span>
                            <?php endif; ?>
                            <?php if(!$article->is_published): ?>
                                <span class="badge bg-secondary status-badge">مسودة</span>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Reading Time -->
                        <?php if($article->reading_time): ?>
                            <div class="position-absolute top-0 end-0 m-2">
                                <span class="reading-time">
                                    <i class="fas fa-clock me-1"></i><?php echo e($article->reading_time); ?> دقيقة
                                </span>
                            </div>
                        <?php endif; ?>
                        
                        <!-- Quick Actions -->
                        <div class="position-absolute bottom-0 end-0 m-2">
                            <div class="btn-group btn-group-sm">
                                <button class="btn btn-light btn-sm" 
                                        onclick="toggleFeatured(<?php echo e($article->id); ?>)"
                                        title="تبديل المميز">
                                    <i class="fas fa-star <?php echo e($article->is_featured ? 'text-warning' : ''); ?>"></i>
                                </button>
                                <button class="btn btn-light btn-sm" 
                                        onclick="togglePublished(<?php echo e($article->id); ?>)"
                                        title="تبديل النشر">
                                    <i class="fas fa-eye <?php echo e($article->is_published ? 'text-success' : 'text-muted'); ?>"></i>
                                </button>
                            </div>
                        </div>
                    </div>
                    
                    <div class="card-body d-flex flex-column">
                        <h5 class="card-title"><?php echo e(Str::limit($article->title, 50)); ?></h5>
                        <p class="card-text flex-grow-1">
                            <?php echo e(Str::limit(strip_tags($article->excerpt ?: $article->content), 120)); ?>

                        </p>
                        
                        <!-- Category -->
                        <div class="mb-2">
                            <span class="badge bg-light text-dark"><?php echo e($article->category); ?></span>
                        </div>
                        
                        <!-- Meta Information -->
                        <div class="article-meta">
                            <div class="meta-item">
                                <i class="fas fa-eye"></i>
                                <?php echo e(number_format($article->views_count)); ?>

                            </div>
                            <div class="meta-item">
                                <i class="fas fa-calendar"></i>
                                <?php echo e($article->created_at->format('Y/m/d')); ?>

                            </div>
                            <?php if($article->published_at): ?>
                            <div class="meta-item">
                                <i class="fas fa-globe"></i>
                                <?php echo e($article->published_at->format('Y/m/d')); ?>

                            </div>
                            <?php endif; ?>
                        </div>
                        
                        <!-- Action Buttons -->
                        <div class="mt-3">
                            <div class="btn-group w-100">
                                <a href="<?php echo e(route('admin.articles.show', $article)); ?>" 
                                   class="btn btn-outline-info btn-sm">
                                    <i class="fas fa-eye me-1"></i>عرض
                                </a>
                                <a href="<?php echo e(route('admin.articles.edit', $article)); ?>" 
                                   class="btn btn-outline-warning btn-sm">
                                    <i class="fas fa-edit me-1"></i>تعديل
                                </a>
                                <a href="<?php echo e(route('admin.articles.preview', $article)); ?>" 
                                   class="btn btn-outline-success btn-sm" target="_blank">
                                    <i class="fas fa-external-link-alt me-1"></i>معاينة
                                </a>
                                <button class="btn btn-outline-danger btn-sm" 
                                        onclick="deleteArticle(<?php echo e($article->id); ?>)">
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
                        <i class="fas fa-newspaper fa-3x text-muted mb-3"></i>
                        <h5 class="text-muted">لا توجد مقالات</h5>
                        <p class="text-muted">لم يتم العثور على أي مقالات. قم بإضافة مقال جديد للبدء.</p>
                        <a href="<?php echo e(route('admin.articles.create')); ?>" class="btn btn-primary">
                            <i class="fas fa-plus me-2"></i>إضافة مقال جديد
                        </a>
                    </div>
                </div>
            </div>
        <?php endif; ?>
    </div>

    <!-- Pagination -->
    <?php if($articles->hasPages()): ?>
        <div class="d-flex justify-content-center mt-4">
            <?php echo e($articles->appends(request()->query())->links()); ?>

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
                هل أنت متأكد من حذف هذا المقال؟ هذا الإجراء لا يمكن التراجع عنه.
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
let articleToDelete = null;

function deleteArticle(id) {
    articleToDelete = id;
    new bootstrap.Modal(document.getElementById('deleteModal')).show();
}

document.getElementById('confirmDelete').addEventListener('click', function() {
    if (articleToDelete) {
        const form = document.createElement('form');
        form.method = 'POST';
        form.action = `/admin/articles/${articleToDelete}`;
        form.innerHTML = `
            <?php echo csrf_field(); ?>
            <?php echo method_field('DELETE'); ?>
        `;
        document.body.appendChild(form);
        form.submit();
    }
});

function toggleFeatured(id) {
    fetch(`/admin/articles/${id}/toggle-featured`, {
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
    fetch(`/admin/articles/${id}/toggle-published`, {
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

<?php echo $__env->make('layouts.admin', array_diff_key(get_defined_vars(), ['__data' => 1, '__path' => 1]))->render(); ?><?php /**PATH C:\Users\osaid\BasmahApp\resources\views/admin/articles/index.blade.php ENDPATH**/ ?>