<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="<?php echo e(csrf_token()); ?>">
    
    <title><?php echo $__env->yieldContent('title', 'أنوار العلوم'); ?></title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <!-- Arabic Fonts -->
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
            font-family: 'Cairo', sans-serif;
            background: linear-gradient(135deg, var(--islamic-teal) 0%, var(--islamic-dark-teal) 100%);
            min-height: 100vh;
            position: relative;
        }

        body::before {
            content: '';
            position: fixed;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(212, 168, 83, 0.2) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(212, 168, 83, 0.1) 0%, transparent 50%),
                repeating-linear-gradient(45deg, transparent, transparent 20px, rgba(212, 168, 83, 0.05) 20px, rgba(212, 168, 83, 0.05) 40px);
            pointer-events: none;
            z-index: -1;
        }

        .main-container {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 2rem 0;
        }

        .content-card {
            background: rgba(250, 249, 247, 0.98);
            backdrop-filter: blur(15px);
            border-radius: 25px;
            box-shadow: 0 25px 70px rgba(44, 122, 123, 0.3);
            padding: 3rem;
            width: 100%;
            max-width: 500px;
            border: 2px solid var(--islamic-gold);
            position: relative;
            overflow: hidden;
        }

        .content-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: 
                repeating-linear-gradient(90deg, transparent, transparent 50px, rgba(212, 168, 83, 0.03) 50px, rgba(212, 168, 83, 0.03) 52px);
            pointer-events: none;
        }

        .islamic-logo {
            text-align: center;
            margin-bottom: 2rem;
        }

        .logo-icon {
            color: var(--islamic-gold);
            animation: shimmer 3s ease-in-out infinite;
            text-shadow: 0 0 15px rgba(212, 168, 83, 0.5);
        }

        @keyframes shimmer {
            0%, 100% { opacity: 1; transform: scale(1); }
            50% { opacity: 0.8; transform: scale(1.05); }
        }

        .brand-text {
            font-family: 'Amiri', serif;
            font-weight: 700;
            font-size: 2rem;
            color: var(--islamic-teal);
            text-shadow: 1px 1px 3px rgba(44, 122, 123, 0.3);
            margin-top: 1rem;
        }

        .btn-custom {
            border-radius: 15px;
            padding: 15px 35px;
            font-weight: 600;
            text-decoration: none;
            transition: all 0.3s ease;
            border: none;
            font-size: 1.1rem;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--islamic-teal) 0%, var(--islamic-dark-teal) 100%);
            color: white;
            border: 2px solid var(--islamic-gold);
        }

        .btn-primary-custom:hover {
            background: linear-gradient(135deg, var(--islamic-dark-teal) 0%, var(--islamic-teal) 100%);
            transform: translateY(-3px);
            box-shadow: 0 10px 25px rgba(44, 122, 123, 0.4);
            color: white;
        }

        .text-gradient {
            background: linear-gradient(135deg, var(--islamic-teal) 0%, var(--islamic-gold) 100%);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            background-clip: text;
            font-weight: 700;
        }

        .form-control {
            border: 2px solid rgba(44, 122, 123, 0.3);
            border-radius: 12px;
            padding: 12px 15px;
            font-size: 1rem;
            transition: all 0.3s ease;
            background: rgba(250, 249, 247, 0.9);
        }

        .form-control:focus {
            border-color: var(--islamic-gold);
            box-shadow: 0 0 0 0.25rem rgba(212, 168, 83, 0.25);
            background: white;
        }

        .form-label {
            color: var(--islamic-dark-teal);
            font-weight: 600;
            margin-bottom: 8px;
        }

        .alert-custom {
            border: none;
            border-radius: 15px;
            padding: 1rem;
            border: 2px solid var(--islamic-gold);
            background: rgba(212, 168, 83, 0.1);
        }

        .alert-danger {
            background: rgba(220, 53, 69, 0.1);
            border: 2px solid #dc3545;
            color: #721c24;
        }

        .alert-success {
            background: rgba(212, 168, 83, 0.1);
            border: 2px solid var(--islamic-gold);
            color: var(--islamic-dark-teal);
        }
    </style>
    
    <?php echo $__env->yieldContent('styles'); ?>
</head>
<body>
    <div class="main-container">
        <div class="content-card">
            <div class="islamic-logo">
                <i class="fas fa-mosque fa-4x logo-icon"></i>
                <h1 class="brand-text">أنوار العلوم</h1>
                <p class="text-muted" style="color: var(--islamic-teal) !important; font-weight: 500;">منصة التعليم الإسلامي</p>
            </div>
            <?php echo $__env->yieldContent('content'); ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    
    <!-- Session Messages -->
    <?php if(session('success')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-success alert-dismissible fade show position-fixed';
                alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                alertDiv.innerHTML = `
                    <i class="fas fa-check-circle me-2"></i>
                    <?php echo e(session('success')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(alertDiv);
                
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            });
        </script>
    <?php endif; ?>
    
    <?php if(session('error')): ?>
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const alertDiv = document.createElement('div');
                alertDiv.className = 'alert alert-danger alert-dismissible fade show position-fixed';
                alertDiv.style.cssText = 'top: 20px; right: 20px; z-index: 9999; min-width: 300px;';
                alertDiv.innerHTML = `
                    <i class="fas fa-exclamation-circle me-2"></i>
                    <?php echo e(session('error')); ?>

                    <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                `;
                document.body.appendChild(alertDiv);
                
                setTimeout(() => {
                    if (alertDiv.parentNode) {
                        alertDiv.remove();
                    }
                }, 5000);
            });
        </script>
    <?php endif; ?>
    
    <?php echo $__env->yieldContent('scripts'); ?>
</body>
</html>
<?php /**PATH /home/u994369532/basmah/resources/views/layouts/app.blade.php ENDPATH**/ ?>