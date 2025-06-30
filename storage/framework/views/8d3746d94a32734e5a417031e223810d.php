<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'لوحة الطالب'); ?> - أنوار العلوم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --islamic-gold: #d4a853;
            --islamic-light-gold: #e6c76f;
            --islamic-dark-gold: #b8923d;
            --islamic-teal: #2c7a7b;
            --islamic-light-teal: #4a9b9d;
            --islamic-dark-teal: #234e52;
            --islamic-off-white: #faf9f7;
            --islamic-cream: #f7f6f4;
            --islamic-dark-blue: #1a365d;
            --transition: all 0.3s ease;
            --shadow: 0 4px 6px -1px rgba(44, 122, 123, 0.1), 0 2px 4px -1px rgba(44, 122, 123, 0.06);
            --shadow-lg: 0 20px 25px -5px rgba(44, 122, 123, 0.1), 0 10px 10px -5px rgba(44, 122, 123, 0.04);
            --border-radius: 15px;
        }

        body {
            background: linear-gradient(135deg, var(--islamic-off-white) 0%, var(--islamic-cream) 100%);
            min-height: 100vh;
            font-family: 'Cairo', sans-serif;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 25px, rgba(212, 168, 83, 0.05) 25px, rgba(212, 168, 83, 0.05) 50px),
                repeating-linear-gradient(-45deg, transparent, transparent 25px, rgba(44, 122, 123, 0.05) 25px, rgba(44, 122, 123, 0.05) 50px),
                radial-gradient(circle at 25% 25%, rgba(212, 168, 83, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(44, 122, 123, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .main-container {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            border: 2px solid rgba(212, 168, 83, 0.2);
            margin: 20px;
            min-height: calc(100vh - 40px);
            box-shadow: var(--shadow-lg);
            border: 1px solid rgba(212, 168, 83, 0.2);
        }

        .header {
            background: linear-gradient(135deg, var(--islamic-teal), var(--islamic-light-teal));
            color: white;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
            padding: 30px;
            position: relative;
            overflow: hidden;
        }

        .header::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(212, 168, 83, 0.1) 10px, rgba(212, 168, 83, 0.1) 20px);
            pointer-events: none;
        }

        .islamic-logo-header {
            width: 50px;
            height: 50px;
            background: linear-gradient(135deg, var(--islamic-gold), var(--islamic-light-gold));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            position: relative;
            overflow: hidden;
            margin-right: 15px;
        }

        .islamic-logo-header::before {
            content: '';
            position: absolute;
            top: -50%;
            left: -50%;
            width: 200%;
            height: 200%;
            background: linear-gradient(45deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transform: rotate(45deg);
            animation: shimmer 3s infinite;
        }

        @keyframes shimmer {
            0% { transform: translateX(-100%) translateY(-100%) rotate(45deg); }
            100% { transform: translateX(100%) translateY(100%) rotate(45deg); }
        }

        .brand-title {
            font-family: 'Amiri', serif;
            font-size: 1.8rem;
            font-weight: 700;
            margin: 0;
            color: var(--islamic-gold);
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
        }

        .card {
            border: none;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: var(--transition);
            background: white;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: var(--shadow-lg);
        }

        .stats-card {
            background: linear-gradient(135deg, var(--islamic-gold), var(--islamic-light-gold));
            color: white;
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 15px, rgba(255, 255, 255, 0.1) 15px, rgba(255, 255, 255, 0.1) 30px);
            pointer-events: none;
        }

        .lesson-card {
            border-left: 5px solid var(--islamic-teal);
            transition: var(--transition);
            border: 1px solid rgba(212, 168, 83, 0.2);
        }

        .lesson-card:hover {
            border-left-color: var(--islamic-gold);
            box-shadow: 0 8px 25px rgba(44, 122, 123, 0.15);
        }

        .btn-check-in {
            background: linear-gradient(135deg, var(--islamic-teal), var(--islamic-light-teal));
            border: none;
            border-radius: 25px;
            padding: 12px 30px;
            font-weight: 600;
            box-shadow: 0 4px 15px rgba(44, 122, 123, 0.3);
            transition: var(--transition);
            color: white;
        }

        .btn-check-in:hover {
            transform: translateY(-2px);
            box-shadow: 0 8px 25px rgba(44, 122, 123, 0.4);
            color: white;
        }

        .btn-islamic {
            background: linear-gradient(135deg, var(--islamic-gold), var(--islamic-light-gold));
            border: none;
            color: white;
            font-weight: 600;
            border-radius: var(--border-radius);
            transition: var(--transition);
            box-shadow: var(--shadow);
        }

        .btn-islamic:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        .status-badge {
            font-size: 0.9em;
            padding: 8px 15px;
            border-radius: 20px;
        }

        .attendance-item {
            border-left: 4px solid #dee2e6;
            transition: var(--transition);
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
        }

        .attendance-item:hover {
            border-left-color: var(--gold);
            background-color: var(--light-gray);
        }

        .floating-stats {
            position: sticky;
            top: 20px;
        }

        .text-islamic {
            color: var(--teal-dark);
        }

        .text-gold {
            color: var(--gold);
        }

        .bg-islamic {
            background: linear-gradient(135deg, var(--teal), var(--teal-light));
        }

        .bg-gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
        }

        .border-islamic {
            border-color: var(--teal) !important;
        }

        .border-gold {
            border-color: var(--gold) !important;
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="main-container">        <!-- Header -->
        <div class="header">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <div class="d-flex align-items-center mb-2">
                        <div class="islamic-logo-header">
                            <i class="fas fa-mosque"></i>
                        </div>
                        <div>
                            <h3 class="brand-title mb-0">أنوار العلوم</h3>
                            <small class="opacity-75">مرحباً <?php echo e(auth()->user()->name); ?></small>
                        </div>
                    </div>
                </div>
                <div class="text-end">
                    <div class="mb-2">
                        <small class="opacity-75"><?php echo e(now()->locale('ar')->isoFormat('dddd، D MMMM YYYY')); ?></small>
                    </div>
                    <div class="mb-3">
                        <small class="opacity-75"><?php echo e(now()->format('H:i')); ?></small>
                    </div>
                    <!-- زر تسجيل الخروج -->
                    <div>
                        <form method="POST" action="<?php echo e(route('admin.logout')); ?>" class="d-inline">
                            <?php echo csrf_field(); ?>
                            <button type="submit" class="btn btn-outline-light btn-sm" 
                                    onclick="return confirm('هل أنت متأكد من تسجيل الخروج؟')">
                                <i class="fas fa-sign-out-alt me-2"></i>
                                تسجيل الخروج
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>

        <!-- Content -->
        <div class="p-4">
            <?php if(session('success')): ?>
                <div class="alert alert-success alert-dismissible fade show" role="alert">
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('error')): ?>
                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php if(session('info')): ?>
                <div class="alert alert-info alert-dismissible fade show" role="alert">
                    <i class="fas fa-info-circle me-2"></i>
                    <?php echo e(session('info')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                </div>
            <?php endif; ?>

            <?php echo $__env->yieldContent('content'); ?>
        </div>

        <!-- Footer -->
        <div class="text-center py-3 border-top" style="border-color: rgba(212, 168, 83, 0.3) !important;">
            <small style="color: var(--islamic-dark-teal);">
                <i class="fas fa-mosque me-1" style="color: var(--islamic-gold);"></i>
                أنوار العلوم - منصة التعليم الإسلامي الذكي
            </small>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\osaid\BasmahApp\resources\views/layouts/student.blade.php ENDPATH**/ ?>