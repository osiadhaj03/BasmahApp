<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $__env->yieldContent('title', 'لوحة التحكم'); ?> - أنوار العلوم</title>
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Cairo:wght@300;400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --islamic-gold: #d4a853;
            --islamic-teal: #2c7a7b;
            --islamic-off-white: #faf9f7;
            --islamic-dark-teal: #1a5a5b;
            --islamic-light-gold: #e8c574;
            --islamic-cream: #f7f5f1;
        }

        body {
            background: linear-gradient(135deg, var(--islamic-off-white) 0%, var(--islamic-cream) 100%);
            font-family: 'Cairo', sans-serif;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(212, 168, 83, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(44, 122, 123, 0.1) 0%, transparent 50%);
            pointer-events: none;
            z-index: -1;
        }

        .sidebar {
            background: linear-gradient(135deg, var(--islamic-teal) 0%, var(--islamic-dark-teal) 100%);
            min-height: 100vh;
            color: white;
            position: relative;
            box-shadow: 0 0 30px rgba(44, 122, 123, 0.3);
        }

        .sidebar::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(212, 168, 83, 0.1) 10px, rgba(212, 168, 83, 0.1) 20px);
            pointer-events: none;
        }

        .islamic-logo {
            display: flex;
            align-items: center;
            justify-content: center;
            flex-direction: column;
            margin-bottom: 1rem;
        }

        .logo-icon {
            color: var(--islamic-gold);
            animation: shimmer 3s ease-in-out infinite;
            text-shadow: 0 0 10px rgba(212, 168, 83, 0.5);
        }

        @keyframes shimmer {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }

        .brand-text {
            font-family: 'Amiri', serif;
            font-weight: 700;
            font-size: 1.4rem;
            color: var(--islamic-gold);
            text-shadow: 1px 1px 3px rgba(0, 0, 0, 0.3);
            margin-top: 0.5rem;
        }

        .sidebar .nav-link {
            color: rgba(255, 255, 255, 0.9);
            padding: 15px 20px;
            border-radius: 12px;
            margin: 5px 10px;
            transition: all 0.3s ease;
            border: 1px solid transparent;
            position: relative;
            backdrop-filter: blur(10px);
        }

        .sidebar .nav-link:hover {
            background: linear-gradient(135deg, var(--islamic-gold) 0%, var(--islamic-light-gold) 100%);
            color: var(--islamic-dark-teal);
            border-color: var(--islamic-gold);
            transform: translateX(-5px);
            box-shadow: 0 5px 15px rgba(212, 168, 83, 0.3);
        }

        .sidebar .nav-link.active {
            background: linear-gradient(135deg, var(--islamic-gold) 0%, var(--islamic-light-gold) 100%);
            color: var(--islamic-dark-teal);
            border-color: var(--islamic-gold);
            font-weight: 600;
        }

        .user-info {
            background: rgba(212, 168, 83, 0.2);
            border-radius: 15px;
            padding: 20px;
            margin: 20px 10px;
            border: 1px solid rgba(212, 168, 83, 0.3);
            backdrop-filter: blur(10px);
        }

        .main-content {
            padding: 30px;
            position: relative;
        }

        .card {
            border: none;
            border-radius: 20px;
            box-shadow: 0 8px 25px rgba(44, 122, 123, 0.1);
            background: rgba(255, 255, 255, 0.95);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(212, 168, 83, 0.2);
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 35px rgba(44, 122, 123, 0.15);
        }

        .btn-primary {
            background: linear-gradient(135deg, var(--islamic-teal) 0%, var(--islamic-dark-teal) 100%);
            border: none;
            border-radius: 12px;
            padding: 12px 24px;
            font-weight: 600;
            transition: all 0.3s ease;
            box-shadow: 0 4px 15px rgba(44, 122, 123, 0.3);
        }

        .btn-primary:hover {
            background: linear-gradient(135deg, var(--islamic-dark-teal) 0%, var(--islamic-teal) 100%);
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(44, 122, 123, 0.4);
        }

        .btn-success {
            background: linear-gradient(135deg, var(--islamic-gold) 0%, var(--islamic-light-gold) 100%);
            border: none;
            border-radius: 12px;
            color: var(--islamic-dark-teal);
            font-weight: 600;
            transition: all 0.3s ease;
        }

        .btn-success:hover {
            background: linear-gradient(135deg, var(--islamic-light-gold) 0%, var(--islamic-gold) 100%);
            color: var(--islamic-dark-teal);
            transform: translateY(-2px);
        }

        .stats-card {
            background: linear-gradient(135deg, var(--islamic-teal) 0%, var(--islamic-dark-teal) 100%);
            color: white;
            border-radius: 20px;
            border: 1px solid var(--islamic-gold);
            position: relative;
            overflow: hidden;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: linear-gradient(45deg, transparent, rgba(212, 168, 83, 0.1), transparent);
            transform: translateX(-100%);
            animation: shimmer-sweep 3s infinite;
        }

        @keyframes shimmer-sweep {
            0% { transform: translateX(-100%); }
            50% { transform: translateX(100%); }
            100% { transform: translateX(100%); }
        }

        .table th {
            background: linear-gradient(135deg, var(--islamic-off-white) 0%, var(--islamic-cream) 100%);
            border-top: none;
            color: var(--islamic-dark-teal);
            font-weight: 600;
        }

        .badge {
            font-size: 0.8em;
            padding: 8px 12px;
            border-radius: 20px;
            font-weight: 500;
        }

        .badge.bg-light {
            background: linear-gradient(135deg, var(--islamic-gold) 0%, var(--islamic-light-gold) 100%) !important;
            color: var(--islamic-dark-teal) !important;
        }

        .alert-success {
            background: linear-gradient(135deg, rgba(212, 168, 83, 0.1) 0%, rgba(212, 168, 83, 0.05) 100%);
            border: 1px solid var(--islamic-gold);
            color: var(--islamic-dark-teal);
            border-radius: 15px;
        }

        .alert-danger {
            background: linear-gradient(135deg, rgba(220, 53, 69, 0.1) 0%, rgba(220, 53, 69, 0.05) 100%);
            border: 1px solid #dc3545;
            border-radius: 15px;
        }

        .btn-outline-light {
            border-color: var(--islamic-gold);
            color: var(--islamic-gold);
            background: transparent;
        }

        .btn-outline-light:hover {
            background: var(--islamic-gold);
            border-color: var(--islamic-gold);
            color: var(--islamic-dark-teal);
        }
    </style>
    <?php echo $__env->yieldPushContent('styles'); ?>
</head>
<body>
    <div class="container-fluid">
        <div class="row">
            <!-- Sidebar -->
            <div class="col-md-3 col-lg-2 sidebar">
                <div class="text-center py-4">
                    <div class="islamic-logo">
                        <i class="fas fa-mosque fa-3x mb-2 logo-icon"></i>
                        <h4 class="brand-text">أنوار العلوم</h4>
                    </div>
                    
                    <div class="user-info text-center">
                        <div class="mb-2">
                            <strong style="color: var(--islamic-gold);"><?php echo e(auth()->user()->name); ?></strong>
                        </div>
                        <span class="badge bg-light text-dark">
                            <?php echo e(auth()->user()->role === 'admin' ? 'مدير النظام' : 'معلم'); ?>

                        </span>
                    </div>
                </div>

                <nav class="nav flex-column">
                    <?php if(auth()->user()->role === 'admin'): ?>
                        <a class="nav-link <?php echo e(request()->routeIs('admin.dashboard') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('admin.dashboard')); ?>">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            الرئيسية
                        </a>
                        <a class="nav-link <?php echo e(request()->routeIs('admin.users.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('admin.users.index')); ?>">
                            <i class="fas fa-users me-2"></i>
                            المستخدمين
                        </a>
                        <a class="nav-link <?php echo e(request()->routeIs('admin.lessons.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('admin.lessons.index')); ?>">
                            <i class="fas fa-book me-2"></i>
                            الدروس
                        </a>
                        <a class="nav-link <?php echo e(request()->routeIs('admin.attendances.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('admin.attendances.index')); ?>">
                            <i class="fas fa-clipboard-check me-2"></i>
                            مراجعة الحضور
                        </a>
                        
                        <!-- Content Management Section -->
                        <hr style="border-color: rgba(212, 168, 83, 0.3); margin: 20px 10px;">
                        <div class="px-3 py-2">
                            <small class="text-uppercase" style="color: var(--islamic-gold); font-weight: 600; letter-spacing: 1px;">إدارة المحتوى</small>
                        </div>
                        
                        <a class="nav-link <?php echo e(request()->routeIs('admin.books.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('admin.books.index')); ?>">
                            <i class="fas fa-book me-2"></i>
                            المكتبة والكتب
                        </a>
                        <a class="nav-link <?php echo e(request()->routeIs('admin.articles.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('admin.articles.index')); ?>">
                            <i class="fas fa-newspaper me-2"></i>
                            المقالات
                        </a>
                        <a class="nav-link <?php echo e(request()->routeIs('admin.news.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('admin.news.index')); ?>">
                            <i class="fas fa-bullhorn me-2"></i>
                            الأخبار والإعلانات
                        </a>
                    <?php elseif(auth()->user()->role === 'teacher'): ?>
                        <a class="nav-link <?php echo e(request()->routeIs('teacher.dashboard') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('teacher.dashboard')); ?>">
                            <i class="fas fa-tachometer-alt me-2"></i>
                            لوحة التحكم
                        </a>
                        <a class="nav-link <?php echo e(request()->routeIs('teacher.lessons.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('teacher.lessons.index')); ?>">
                            <i class="fas fa-book me-2"></i>
                            إدارة دروسي
                        </a>
                        <a class="nav-link <?php echo e(request()->routeIs('teacher.attendances.*') ? 'active' : ''); ?>" 
                           href="<?php echo e(route('teacher.attendances.index')); ?>">
                            <i class="fas fa-clipboard-check me-2"></i>
                            مراجعة الحضور والغياب
                        </a>
                    <?php endif; ?>
                </nav>

                <div class="mt-auto p-3">
                    <form method="POST" action="<?php echo e(route('admin.logout')); ?>">
                        <?php echo csrf_field(); ?>
                        <button type="submit" class="btn btn-outline-light btn-sm w-100">
                            <i class="fas fa-sign-out-alt me-2"></i>
                            تسجيل الخروج
                        </button>
                    </form>
                </div>
            </div>

            <!-- Main Content -->
            <div class="col-md-9 col-lg-10 main-content">
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

                <?php echo $__env->yieldContent('content'); ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <?php echo $__env->yieldPushContent('scripts'); ?>
</body>
</html>
<?php /**PATH C:\Users\osaid\BasmahApp\resources\views/layouts/admin.blade.php ENDPATH**/ ?>