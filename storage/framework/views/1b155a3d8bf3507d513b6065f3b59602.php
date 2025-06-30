<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>تسجيل الدخول - أنوار العلوم</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Amiri:wght@400;700&family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    <style>
        :root {
            --gold: #d4a853;
            --gold-light: #e6c76f;
            --gold-dark: #b8923d;
            --teal: #2c7a7b;
            --teal-light: #4a9b9d;
            --teal-dark: #234e52;
            --off-white: #faf9f7;
            --light-gray: #f7f6f4;
            --dark-teal: #1a365d;
            --transition: all 0.3s ease;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
            --border-radius: 12px;
        }

        body {
            background: linear-gradient(135deg, rgba(212, 168, 83, 0.1) 0%, rgba(44, 122, 123, 0.1) 100%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            position: relative;
            overflow-x: hidden;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(212, 168, 83, 0.05) 20px, rgba(212, 168, 83, 0.05) 40px),
                repeating-linear-gradient(-45deg, transparent, transparent 20px, rgba(44, 122, 123, 0.05) 20px, rgba(44, 122, 123, 0.05) 40px);
            pointer-events: none;
            z-index: -1;
        }

        .login-card {
            background: rgba(255, 255, 255, 0.98);
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(212, 168, 83, 0.2);
            max-width: 450px;
            margin: 0 auto;
        }

        .islamic-logo {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 1.5rem;
            font-size: 2rem;
            color: white;
            position: relative;
            overflow: hidden;
            box-shadow: var(--shadow);
        }

        .islamic-logo::before {
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
            color: var(--teal-dark);
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
        }

        .brand-subtitle {
            color: var(--teal);
            font-size: 1.1rem;
            margin-bottom: 0.5rem;
        }

        .form-label {
            color: var(--teal-dark);
            font-weight: 600;
            margin-bottom: 0.5rem;
        }

        .input-group-text {
            background: linear-gradient(135deg, var(--teal), var(--teal-light));
            border: none;
            color: white;
            border-radius: var(--border-radius) 0 0 var(--border-radius);
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-left: none;
            border-radius: 0 var(--border-radius) var(--border-radius) 0;
            padding: 12px 16px;
            transition: var(--transition);
            font-size: 1rem;
        }

        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(212, 168, 83, 0.25);
            outline: none;
        }

        .btn-islamic {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border: none;
            color: white;
            font-weight: 600;
            padding: 14px 30px;
            border-radius: var(--border-radius);
            transition: var(--transition);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
            font-size: 1.1rem;
        }

        .btn-islamic:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        .btn-islamic::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }

        .btn-islamic:hover::before {
            left: 100%;
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            border: 1px solid rgba(220, 53, 69, 0.3);
            color: #dc3545;
            border-radius: var(--border-radius);
        }

        .info-text {
            color: var(--teal);
            font-size: 0.875rem;
            opacity: 0.8;
        }

        .islamic-pattern-bg {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="star" patternUnits="userSpaceOnUse" width="20" height="20"><polygon points="10,0 12,6 20,6 14,10 16,16 10,12 4,16 6,10 0,6 8,6" fill="%23d4a853" opacity="0.05"/></pattern></defs><rect width="100" height="100" fill="url(%23star)"/></svg>');
            pointer-events: none;
            z-index: -1;
        }
    </style>
</head>
<body>
    <div class="islamic-pattern-bg"></div>
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6 col-lg-5">
                <div class="login-card p-5">                    <div class="text-center mb-4">
                        <div class="islamic-logo">
                            <i class="fas fa-mosque"></i>
                        </div>
                        <h2 class="brand-title">أنوار العلوم</h2>
                        <p class="brand-subtitle">تسجيل الدخول</p>
                        <small class="info-text">للطلاب والمعلمين والإداريين</small>
                    </div>

                    <?php if($errors->any()): ?>
                        <div class="alert alert-danger mb-4">
                            <?php $__currentLoopData = $errors->all(); $__env->addLoop($__currentLoopData); foreach($__currentLoopData as $error): $__env->incrementLoopIndices(); $loop = $__env->getLastLoop(); ?>
                                <div><i class="fas fa-exclamation-circle me-1"></i><?php echo e($error); ?></div>
                            <?php endforeach; $__env->popLoop(); $loop = $__env->getLastLoop(); ?>
                        </div>
                    <?php endif; ?>

                    <form method="POST" action="<?php echo e(route('admin.login')); ?>">
                        <?php echo csrf_field(); ?>
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1"></i>
                                البريد الإلكتروني
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-envelope"></i></span>
                                <input type="email" 
                                       class="form-control <?php $__errorArgs = ['email'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="email" 
                                       name="email" 
                                       value="<?php echo e(old('email')); ?>" 
                                       required 
                                       autofocus
                                       placeholder="أدخل بريدك الإلكتروني">
                            </div>
                        </div>

                        <div class="mb-4">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-1"></i>
                                كلمة المرور
                            </label>
                            <div class="input-group">
                                <span class="input-group-text"><i class="fas fa-lock"></i></span>
                                <input type="password" 
                                       class="form-control <?php $__errorArgs = ['password'];
$__bag = $errors->getBag($__errorArgs[1] ?? 'default');
if ($__bag->has($__errorArgs[0])) :
if (isset($message)) { $__messageOriginal = $message; }
$message = $__bag->first($__errorArgs[0]); ?> is-invalid <?php unset($message);
if (isset($__messageOriginal)) { $message = $__messageOriginal; }
endif;
unset($__errorArgs, $__bag); ?>" 
                                       id="password" 
                                       name="password" 
                                       required
                                       placeholder="أدخل كلمة المرور">
                            </div>
                        </div>

                        <div class="d-grid">
                            <button type="submit" class="btn btn-islamic">
                                <i class="fas fa-sign-in-alt me-2"></i>
                                تسجيل الدخول
                            </button>
                        </div>
                    </form>

                    <div class="text-center mt-4">
                        <small class="info-text">
                            <i class="fas fa-info-circle me-1"></i>
                            سيتم توجيهك للوحة المناسبة بناءً على دورك
                        </small>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
<?php /**PATH C:\Users\osaid\BasmahApp\resources\views/auth/admin-login.blade.php ENDPATH**/ ?>