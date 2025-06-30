<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>أنوار العلوم - قناة تعليمية إسلامية</title>
    <meta name="description" content="قناة متخصصة في نشر منهج أهل السنة: فقه وعقيدة وسلوك">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">
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
            --text-primary: #2d3748;
            --text-secondary: #4a5568;
            --border-radius: 12px;
            --transition: all 0.3s ease;
            --shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06);
            --shadow-lg: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }

        body {
            font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            line-height: 1.6;
            color: var(--text-primary);
            background-color: var(--off-white);
            overflow-x: hidden;
        }

        .arabic-font {
            font-family: 'Amiri', serif;
        }

        /* Islamic Geometric Patterns */
        .islamic-pattern {
            background-image: 
                radial-gradient(circle at 25% 25%, rgba(212, 168, 83, 0.1) 0%, transparent 50%),
                radial-gradient(circle at 75% 75%, rgba(44, 122, 123, 0.1) 0%, transparent 50%);
            background-size: 60px 60px;
            position: relative;
        }

        .islamic-pattern::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background-image: 
                repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(212, 168, 83, 0.05) 10px, rgba(212, 168, 83, 0.05) 20px),
                repeating-linear-gradient(-45deg, transparent, transparent 10px, rgba(44, 122, 123, 0.05) 10px, rgba(44, 122, 123, 0.05) 20px);
            pointer-events: none;
        }

        /* Navigation */
        .navbar-custom {
            background: rgba(255, 255, 255, 0.98);
            backdrop-filter: blur(15px);
            box-shadow: var(--shadow);
            transition: var(--transition);
            border-bottom: 1px solid rgba(212, 168, 83, 0.2);
        }

        .navbar-custom.scrolled {
            background: rgba(255, 255, 255, 0.95);
            box-shadow: var(--shadow-lg);
        }

        .navbar-brand {
            font-weight: 700;
            font-size: 1.8rem;
            color: var(--gold);
            display: flex;
            align-items: center;
            gap: 12px;
        }

        .logo-dome {
            width: 45px;
            height: 45px;
            background: linear-gradient(135deg, var(--gold), var(--teal));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.2rem;
            position: relative;
            overflow: hidden;
        }

        .logo-dome::before {
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

        .nav-link {
            color: var(--text-primary) !important;
            font-weight: 600;
            padding: 8px 16px !important;
            margin: 0 4px;
            border-radius: var(--border-radius);
            transition: var(--transition);
            position: relative;
        }

        .nav-link:hover {
            color: var(--gold) !important;
            background-color: rgba(212, 168, 83, 0.1);
            transform: translateY(-2px);
        }

        .nav-link.active {
            color: var(--gold) !important;
            background-color: rgba(212, 168, 83, 0.15);
        }

        .social-links a {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            margin: 0 5px;
            transition: var(--transition);
            text-decoration: none;
        }

        .social-youtube {
            background: linear-gradient(135deg, #ff0000, #cc0000);
            color: white;
        }

        .social-facebook {
            background: linear-gradient(135deg, #1877f2, #0d47a1);
            color: white;
        }

        .social-twitter {
            background: linear-gradient(135deg, #1da1f2, #0d47a1);
            color: white;
        }

        .social-links a:hover {
            transform: translateY(-3px) scale(1.1);
            box-shadow: var(--shadow-lg);
        }

        /* Auth Buttons */
        .auth-buttons .btn {
            font-weight: 600;
            border-radius: 25px;
            padding: 8px 20px;
            transition: var(--transition);
            border-width: 2px;
        }

        .auth-buttons .btn-outline-primary {
            color: var(--teal);
            border-color: var(--teal);
            background: transparent;
        }

        .auth-buttons .btn-outline-primary:hover {
            background: var(--teal);
            border-color: var(--teal);
            color: white;
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        .auth-buttons .btn-gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border: none;
            color: white;
            position: relative;
            overflow: hidden;
        }

        .auth-buttons .btn-gold:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        .auth-buttons .btn-gold::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }

        .auth-buttons .btn-gold:hover::before {
            left: 100%;
        }

        .user-menu .btn {
            font-weight: 600;
            border-radius: 20px;
            padding: 6px 15px;
            transition: var(--transition);
            font-size: 0.875rem;
        }

        .user-menu .btn:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow);
        }

        /* Responsive Auth Buttons */
        @media (max-width: 768px) {
            .auth-buttons {
                flex-direction: column;
                gap: 8px;
                margin-top: 10px;
            }
            
            .auth-buttons .btn {
                width: 100%;
                margin: 0 !important;
            }
            
            .user-menu {
                flex-direction: column;
                gap: 8px;
                margin-top: 10px;
            }
            
            .user-menu .btn,
            .user-menu form {
                width: 100%;
            }
        }

        /* Hero Section */
        .hero-section {
            min-height: 100vh;
            background: linear-gradient(135deg, rgba(212, 168, 83, 0.1) 0%, rgba(44, 122, 123, 0.1) 100%);
            position: relative;
            display: flex;
            align-items: center;
            overflow: hidden;
        }

        .hero-bg {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="star" patternUnits="userSpaceOnUse" width="10" height="10"><polygon points="5,0 6,3 10,3 7,5 8,8 5,6 2,8 3,5 0,3 4,3" fill="%23d4a853" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23star)"/></svg>');
            opacity: 0.3;
        }

        .hero-content {
            position: relative;
            z-index: 2;
        }

        .hero-banner {
            max-width: 100%;
            height: auto;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow-lg);
            border: 4px solid var(--gold);
        }

        .hero-tagline {
            font-size: 2.5rem;
            font-weight: 700;
            color: var(--teal-dark);
            text-shadow: 2px 2px 4px rgba(0, 0, 0, 0.1);
            line-height: 1.2;
        }

        .hero-subtitle {
            font-size: 1.3rem;
            color: var(--text-secondary);
            margin: 20px 0;
        }

        /* Buttons */
        .btn-gold {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border: none;
            color: white;
            font-weight: 600;
            padding: 15px 35px;
            border-radius: 50px;
            transition: var(--transition);
            box-shadow: var(--shadow);
            position: relative;
            overflow: hidden;
        }

        .btn-gold:hover {
            transform: translateY(-3px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        .btn-gold::before {
            content: '';
            position: absolute;
            top: 0;
            left: -100%;
            width: 100%;
            height: 100%;
            background: linear-gradient(90deg, transparent, rgba(255, 255, 255, 0.3), transparent);
            transition: left 0.6s;
        }

        .btn-gold:hover::before {
            left: 100%;
        }

        .btn-teal {
            background: linear-gradient(135deg, var(--teal), var(--teal-light));
            border: none;
            color: white;
            font-weight: 600;
            padding: 12px 28px;
            border-radius: 25px;
            transition: var(--transition);
            box-shadow: var(--shadow);
        }

        .btn-teal:hover {
            transform: translateY(-2px);
            box-shadow: var(--shadow-lg);
            color: white;
        }

        /* Section Styles */
        .section {
            padding: 80px 0;
        }

        .section-title {
            font-size: 2.8rem;
            font-weight: 700;
            color: var(--teal-dark);
            text-align: center;
            margin-bottom: 20px;
            position: relative;
        }

        .section-title::after {
            content: '';
            width: 80px;
            height: 4px;
            background: linear-gradient(135deg, var(--gold), var(--teal));
            position: absolute;
            bottom: -15px;
            left: 50%;
            transform: translateX(-50%);
            border-radius: 2px;
        }

        .section-subtitle {
            font-size: 1.2rem;
            color: var(--text-secondary);
            text-align: center;
            margin-bottom: 60px;
            max-width: 600px;
            margin-left: auto;
            margin-right: auto;
        }

        /* Cards */
        .card-custom {
            background: white;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: var(--transition);
            border: none;
            overflow: hidden;
            height: 100%;
        }

        .card-custom:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .teacher-card {
            text-align: center;
            padding: 30px 20px;
        }

        .teacher-avatar {
            width: 120px;
            height: 120px;
            border-radius: 50%;
            border: 4px solid var(--gold);
            margin: 0 auto 20px;
            overflow: hidden;
            position: relative;
        }

        .teacher-avatar img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }

        .teacher-name {
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--teal-dark);
            margin-bottom: 10px;
        }

        .teacher-specialty {
            color: var(--text-secondary);
            margin-bottom: 20px;
        }

        /* Video Cards */
        .video-card {
            position: relative;
            overflow: hidden;
        }

        .video-thumbnail {
            position: relative;
            overflow: hidden;
            border-radius: var(--border-radius) var(--border-radius) 0 0;
        }

        .video-thumbnail img {
            width: 100%;
            height: 200px;
            object-fit: cover;
            transition: var(--transition);
        }

        .video-card:hover .video-thumbnail img {
            transform: scale(1.1);
        }

        .play-button {
            position: absolute;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%);
            width: 60px;
            height: 60px;
            background: rgba(212, 168, 83, 0.9);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 1.5rem;
            transition: var(--transition);
        }

        .video-card:hover .play-button {
            transform: translate(-50%, -50%) scale(1.2);
            background: var(--gold);
        }

        .video-content {
            padding: 20px;
        }

        .video-title {
            font-weight: 700;
            color: var(--teal-dark);
            margin-bottom: 10px;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        .video-teacher {
            color: var(--text-secondary);
            font-size: 0.9rem;
            margin-bottom: 15px;
        }

        /* Gallery */
        .gallery-item {
            position: relative;
            overflow: hidden;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            cursor: pointer;
        }

        .gallery-item img {
            width: 100%;
            height: 250px;
            object-fit: cover;
            transition: var(--transition);
        }

        .gallery-item:hover img {
            transform: scale(1.1);
        }

        .gallery-overlay {
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: linear-gradient(135deg, rgba(212, 168, 83, 0.8), rgba(44, 122, 123, 0.8));
            opacity: 0;
            transition: var(--transition);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
        }

        .gallery-item:hover .gallery-overlay {
            opacity: 1;
        }

        /* Partners */
        .partner-logo {
            filter: grayscale(100%);
            opacity: 0.7;
            transition: var(--transition);
            max-height: 80px;
            max-width: 150px;
            object-fit: contain;
        }

        .partner-logo:hover {
            filter: grayscale(0%);
            opacity: 1;
            transform: scale(1.1);
        }

        /* News & Announcements */
        .news-item {
            padding: 25px;
            border-left: 4px solid var(--gold);
            background: white;
            border-radius: var(--border-radius);
            margin-bottom: 20px;
            transition: var(--transition);
        }

        .news-item:hover {
            transform: translateX(10px);
            box-shadow: var(--shadow);
        }

        .news-date {
            color: var(--gold);
            font-weight: 600;
            font-size: 0.9rem;
        }

        .news-title {
            font-weight: 700;
            color: var(--teal-dark);
            margin: 10px 0;
        }

        .news-excerpt {
            color: var(--text-secondary);
            margin-bottom: 15px;
        }

        /* Contact Form */
        .contact-form {
            background: white;
            padding: 40px;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
        }

        .form-control {
            border: 2px solid #e2e8f0;
            border-radius: var(--border-radius);
            padding: 15px;
            transition: var(--transition);
        }

        .form-control:focus {
            border-color: var(--gold);
            box-shadow: 0 0 0 0.2rem rgba(212, 168, 83, 0.25);
        }

        /* Footer */
        .footer {
            background: var(--dark-teal);
            color: white;
            padding: 60px 0 30px;
        }

        .footer h5 {
            color: var(--gold);
            margin-bottom: 20px;
        }

        .footer a {
            color: #cbd5e0;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer a:hover {
            color: var(--gold);
        }

        .footer-bottom {
            border-top: 1px solid rgba(255, 255, 255, 0.1);
            margin-top: 40px;
            padding-top: 20px;
            text-align: center;
            color: #a0aec0;
        }

        /* Animations */
        .fade-in-up {
            opacity: 0;
            transform: translateY(50px);
            transition: all 0.8s ease;
        }

        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-tagline {
                font-size: 2rem;
            }

            .section-title {
                font-size: 2.2rem;
            }

            .section {
                padding: 60px 0;
            }

            .hero-section {
                min-height: 80vh;
            }
        }

        /* Authentication Buttons Styles */
        .btn:hover {
            transform: translateY(-1px);
            box-shadow: 0 4px 12px rgba(0,0,0,0.1);
        }
        
        .btn-outline-primary:hover {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            border-color: var(--gold);
            color: white;
        }
        
        .btn-primary:hover {
            background: linear-gradient(135deg, var(--teal-dark), var(--teal));
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(44, 122, 123, 0.3);
        }
        
        .btn-outline-danger:hover {
            background: #dc3545;
            color: white;
        }
        
        /* Responsive adjustments for auth buttons */
        @media (max-width: 991px) {
            .d-flex.align-items-center.gap-3 {
                flex-direction: column;
                gap: 0.5rem !important;
            }
            
            .btn-sm {
                width: 100%;
                margin-bottom: 0.25rem;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
        }

        ::-webkit-scrollbar-track {
            background: var(--light-gray);
        }

        ::-webkit-scrollbar-thumb {
            background: var(--gold);
            border-radius: 4px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--gold-dark);
        }

        /* Buttons */
        .btn-custom {
            border-radius: 50px;
            padding: 15px 40px;
            font-weight: 600;
            text-decoration: none;
            transition: var(--transition);
            border: none;
            margin: 0.5rem;
            font-size: 1.1rem;
            position: relative;
            overflow: hidden;
        }

        .btn-primary-custom {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: white;
            box-shadow: 0 8px 30px rgba(212, 168, 83, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(212, 168, 83, 0.4);
            color: white;
        }

        .btn-success-custom {
            background: linear-gradient(135deg, var(--teal), var(--teal-light));
            color: white;
            box-shadow: 0 8px 30px rgba(44, 122, 123, 0.3);
        }

        .btn-success-custom:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(44, 122, 123, 0.4);
            color: white;
        }

        .btn-outline-custom {
            border: 2px solid var(--gold);
            color: var(--gold);
            background: transparent;
        }

        .btn-outline-custom:hover {
            background: var(--gold);
            color: white;
            transform: translateY(-3px);
        }

        /* Features Section */
        .features-section {
            padding: 100px 0;
            background: var(--light-gray);
        }

        .feature-card {
            background: white;
            padding: 3rem 2rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: var(--transition);
            height: 100%;
            position: relative;
            overflow: hidden;
        }

        .feature-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 5px;
            background: linear-gradient(135deg, var(--gold), var(--teal));
        }

        .feature-card:hover {
            transform: translateY(-10px);
            box-shadow: var(--shadow-lg);
        }

        .feature-icon {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, var(--gold), var(--teal));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 2rem;
            margin: 0 auto 2rem;
            box-shadow: 0 10px 30px rgba(212, 168, 83, 0.3);
        }

        /* How it Works */
        .how-it-works {
            padding: 100px 0;
            background: white;
        }

        .step-card {
            text-align: center;
            padding: 2rem;
            position: relative;
        }

        .step-number {
            width: 60px;
            height: 60px;
            background: linear-gradient(135deg, var(--gold), var(--teal));
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: bold;
            font-size: 1.5rem;
            margin: 0 auto 1rem;
            position: relative;
            z-index: 2;
        }

        .step-line {
            position: absolute;
            top: 30px;
            left: 50%;
            width: 100%;
            height: 2px;
            background: linear-gradient(90deg, transparent 0%, var(--gold) 50%, transparent 100%);
            z-index: 1;
        }

        /* Statistics */
        .stats-section {
            padding: 80px 0;
            background: linear-gradient(135deg, var(--teal), var(--teal-dark));
            color: white;
        }

        .stat-card {
            text-align: center;
            padding: 2rem;
        }

        .stat-number {
            font-size: 3rem;
            font-weight: 900;
            margin-bottom: 0.5rem;
            display: block;
        }

        .stat-label {
            font-size: 1.1rem;
            opacity: 0.9;
        }

        /* Screenshots */
        .screenshots-section {
            padding: 100px 0;
            background: var(--light-gray);
        }

        .screenshot-card {
            background: white;
            padding: 1rem;
            border-radius: var(--border-radius);
            box-shadow: var(--shadow);
            transition: var(--transition);
        }

        .screenshot-card:hover {
            transform: scale(1.05);
            box-shadow: var(--shadow-lg);
        }

        .screenshot-img {
            width: 100%;
            height: 300px;
            background: linear-gradient(135deg, rgba(212, 168, 83, 0.2), rgba(44, 122, 123, 0.2));
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 4rem;
            color: var(--gold);
            margin-bottom: 1rem;
        }

        /* Auth Notice */
        .auth-notice {
            background: linear-gradient(135deg, var(--gold), var(--gold-light));
            color: white;
            padding: 1.5rem;
            border-radius: var(--border-radius);
            margin: 2rem 0;
            text-align: center;
            box-shadow: 0 10px 30px rgba(212, 168, 83, 0.3);
        }

        /* Footer */
        .footer-section {
            background: var(--dark-teal);
            color: white;
            padding: 60px 0 30px;
        }

        .footer-links a {
            color: #cbd5e0;
            text-decoration: none;
            transition: var(--transition);
        }

        .footer-links a:hover {
            color: var(--gold);
        }

        /* Animations */
        .fade-in-up {
            opacity: 0;
            transform: translateY(30px);
            transition: all 0.6s ease;
        }

        .fade-in-up.visible {
            opacity: 1;
            transform: translateY(0);
        }

        /* Responsive */
        @media (max-width: 768px) {
            .hero-title {
                font-size: 2.5rem;
            }
            
            .hero-subtitle {
                font-size: 1.2rem;
            }
            
            .feature-card {
                margin-bottom: 2rem;
            }
        }
    </style>
</head>
<body>
    <!-- Navigation -->
    <nav class="navbar navbar-expand-lg navbar-light fixed-top navbar-custom">
        <div class="container">
            <a class="navbar-brand arabic-font" href="#home">
                <div class="logo-dome">
                    <i class="fas fa-mosque"></i>
                </div>
                أنوار العلوم
            </a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarNav">
                <ul class="navbar-nav mx-auto">
                    <li class="nav-item">
                        <a class="nav-link active" href="#home">الرئيسية</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#about">عن القناة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#teachers">المعلمون</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#videos">الدروس</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#articles">المقالات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#library">المكتبة</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#gallery">المعرض</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#partners">الشراكات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#announcements">الإعلانات</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="#contact">التواصل</a>
                    </li>
                </ul>
                <div class="d-flex align-items-center">
                <div class="d-flex align-items-center gap-3">
                    <!-- Authentication Buttons -->
                    <?php if(auth()->guard()->guest()): ?>
                        <a href="<?php echo e(route('student.register.form')); ?>" class="btn btn-outline-primary btn-sm px-3 py-2" style="border-color: var(--gold); color: var(--gold); border-radius: 25px; font-weight: 600; transition: var(--transition);">
                            <i class="fas fa-user-plus me-1"></i>
                            تسجيل طالب جديد
                        </a>
                        <a href="<?php echo e(route('admin.login')); ?>" class="btn btn-primary btn-sm px-3 py-2" style="background: linear-gradient(135deg, var(--teal), var(--teal-light)); border: none; border-radius: 25px; font-weight: 600; transition: var(--transition);">
                            <i class="fas fa-sign-in-alt me-1"></i>
                            تسجيل الدخول
                        </a>
                    <?php else: ?>
                        <?php if(auth()->user()->role === 'admin'): ?>
                            <a href="<?php echo e(route('admin.dashboard')); ?>" class="btn btn-success btn-sm px-3 py-2" style="background: linear-gradient(135deg, var(--gold), var(--gold-light)); border: none; border-radius: 25px; font-weight: 600;">
                                <i class="fas fa-tachometer-alt me-1"></i>
                                لوحة الإدارة
                            </a>
                        <?php elseif(auth()->user()->role === 'teacher'): ?>
                            <a href="<?php echo e(route('teacher.dashboard')); ?>" class="btn btn-success btn-sm px-3 py-2" style="background: linear-gradient(135deg, var(--gold), var(--gold-light)); border: none; border-radius: 25px; font-weight: 600;">
                                <i class="fas fa-chalkboard-teacher me-1"></i>
                                لوحة المعلم
                            </a>
                        <?php else: ?>
                            <a href="<?php echo e(route('student.dashboard')); ?>" class="btn btn-success btn-sm px-3 py-2" style="background: linear-gradient(135deg, var(--gold), var(--gold-light)); border: none; border-radius: 25px; font-weight: 600;">
                                <i class="fas fa-user-graduate me-1"></i>
                                لوحة الطالب
                            </a>
                        <?php endif; ?>
                        <a href="<?php echo e(route('admin.logout')); ?>" class="btn btn-outline-danger btn-sm px-3 py-2" style="border-color: #dc3545; color: #dc3545; border-radius: 25px; font-weight: 600;">
                            <i class="fas fa-sign-out-alt me-1"></i>
                            تسجيل الخروج
                        </a>
                    <?php endif; ?>
                    
                    <!-- Social Links -->
                    <div class="social-links d-none d-lg-flex ms-3">
                        <a href="#" class="social-youtube">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="social-facebook">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-twitter">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                </div>
            </div>
        </div>
    </nav>

    <!-- Hero Section -->
    <section id="home" class="hero-section islamic-pattern">
        <div class="hero-bg"></div>
        <div class="container">
            <div class="row align-items-center min-vh-100">
                <div class="col-lg-6 hero-content fade-in-up">
                    <h1 class="hero-tagline arabic-font mb-4">
                        قناة متخصصة في نشر منهج أهل السنة: فقه وعقيدة وسلوك
                    </h1>
                    <p class="hero-subtitle">
                        انضم إلينا في رحلة طلب العلم الشرعي واكتساب المعرفة الإسلامية الصحيحة من علمائنا الأجلاء
                    </p>
                    <div class="mt-4">
                        <a href="#videos" class="btn btn-gold btn-lg me-3">
                            <i class="fas fa-play me-2"></i>
                            شاهد أحدث الدروس
                        </a>
                        <a href="#about" class="btn btn-outline-secondary btn-lg">
                            تعرف على القناة
                        </a>
                    </div>
                </div>
                <div class="col-lg-6 text-center fade-in-up">
                    <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='500' height='300' viewBox='0 0 500 300'><rect width='500' height='300' fill='%23f7f6f4'/><rect x='50' y='50' width='400' height='200' fill='%23d4a853' rx='12'/><text x='250' y='160' text-anchor='middle' fill='white' font-family='Arial' font-size='24' font-weight='bold'>أنوار العلوم</text><text x='250' y='190' text-anchor='middle' fill='white' font-family='Arial' font-size='16'>قناة تعليمية إسلامية</text></svg>" 
                         alt="أنوار العلوم" class="hero-banner animate__animated animate__fadeIn">
                </div>
            </div>
        </div>
    </section>

    <!-- About Section -->
    <section id="about" class="section">
        <div class="container">
            <div class="row">
                <div class="col-lg-8 mx-auto text-center fade-in-up">
                    <h2 class="section-title arabic-font">عن معهد أنوار العلوم</h2>
                    <p class="section-subtitle">
                        معهد متخصص في تعليم العلوم الشرعية وفق منهج أهل السنة والجماعة
                    </p>
                    <div class="row mt-5">
                        <div class="col-md-4 mb-4">
                            <div class="card card-custom text-center">
                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <i class="fas fa-book-open" style="font-size: 3rem; color: var(--gold);"></i>
                                    </div>
                                    <h5 class="card-title">رسالتنا</h5>
                                    <p class="card-text">نشر العلم الشرعي الصحيح وتربية الأجيال على منهج السلف الصالح</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card card-custom text-center">
                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <i class="fas fa-eye" style="font-size: 3rem; color: var(--teal);"></i>
                                    </div>
                                    <h5 class="card-title">رؤيتنا</h5>
                                    <p class="card-text">أن نكون منارة علمية موثوقة في تعليم العقيدة والفقه والسلوك الإسلامي</p>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 mb-4">
                            <div class="card card-custom text-center">
                                <div class="card-body p-4">
                                    <div class="mb-3">
                                        <i class="fas fa-hands-helping" style="font-size: 3rem; color: var(--gold);"></i>
                                    </div>
                                    <h5 class="card-title">قيمنا</h5>
                                    <p class="card-text">الصدق في النقل، والأمانة في التعليم، والحكمة في الدعوة</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Teachers Section -->
    <section id="teachers" class="section" style="background-color: var(--light-gray);">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center fade-in-up">
                    <h2 class="section-title arabic-font">علماؤنا الأجلاء</h2>
                    <p class="section-subtitle">تعرف على نخبة من العلماء والدعاة المتميزين</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4 fade-in-up">
                    <div class="card card-custom teacher-card">
                        <div class="teacher-avatar">
                            <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'><circle cx='60' cy='60' r='60' fill='%23e2e8f0'/><circle cx='60' cy='45' r='20' fill='%23a0aec0'/><ellipse cx='60' cy='90' rx='25' ry='15' fill='%23a0aec0'/></svg>" alt="الشيخ الأول">
                        </div>
                        <h5 class="teacher-name">د. محمد الأحمد</h5>
                        <p class="teacher-specialty">أستاذ الفقه والأصول</p>
                        <a href="#" class="btn btn-teal">عرض الدروس</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 fade-in-up">
                    <div class="card card-custom teacher-card">
                        <div class="teacher-avatar">
                            <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'><circle cx='60' cy='60' r='60' fill='%23e2e8f0'/><circle cx='60' cy='45' r='20' fill='%23a0aec0'/><ellipse cx='60' cy='90' rx='25' ry='15' fill='%23a0aec0'/></svg>" alt="الشيخ الثاني">
                        </div>
                        <h5 class="teacher-name">د. عبد الله الحسن</h5>
                        <p class="teacher-specialty">أستاذ العقيدة والتفسير</p>
                        <a href="#" class="btn btn-teal">عرض الدروس</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 fade-in-up">
                    <div class="card card-custom teacher-card">
                        <div class="teacher-avatar">
                            <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'><circle cx='60' cy='60' r='60' fill='%23e2e8f0'/><circle cx='60' cy='45' r='20' fill='%23a0aec0'/><ellipse cx='60' cy='90' rx='25' ry='15' fill='%23a0aec0'/></svg>" alt="الشيخ الثالث">
                        </div>
                        <h5 class="teacher-name">د. أحمد الطيب</h5>
                        <p class="teacher-specialty">أستاذ الحديث والسيرة</p>
                        <a href="#" class="btn btn-teal">عرض الدروس</a>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 fade-in-up">
                    <div class="card card-custom teacher-card">
                        <div class="teacher-avatar">
                            <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='120' height='120' viewBox='0 0 120 120'><circle cx='60' cy='60' r='60' fill='%23e2e8f0'/><circle cx='60' cy='45' r='20' fill='%23a0aec0'/><ellipse cx='60' cy='90' rx='25' ry='15' fill='%23a0aec0'/></svg>" alt="الشيخ الرابع">
                        </div>
                        <h5 class="teacher-name">د. يوسف العلي</h5>
                        <p class="teacher-specialty">أستاذ الدعوة والأخلاق</p>
                        <a href="#" class="btn btn-teal">عرض الدروس</a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Videos Section -->
    <section id="videos" class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center fade-in-up">
                    <h2 class="section-title arabic-font">أحدث الدروس التعليمية</h2>
                    <p class="section-subtitle">استمع إلى دروس ومحاضرات قيمة في العلوم الشرعية</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                    <div class="card card-custom video-card">
                        <div class="video-thumbnail">
                            <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='400' height='200' viewBox='0 0 400 200'><rect width='400' height='200' fill='%23f7f6f4'/><rect x='50' y='50' width='300' height='100' fill='%23d4a853' rx='8'/><text x='200' y='105' text-anchor='middle' fill='white' font-family='Arial' font-size='16' font-weight='bold'>درس في الفقه</text></svg>" alt="درس في الفقه">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <div class="video-content">
                            <h6 class="video-title">أحكام الصيام في الفقه الإسلامي</h6>
                            <p class="video-teacher">د. محمد الأحمد</p>
                            <a href="#" class="btn btn-teal btn-sm">مشاهدة الدرس</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                    <div class="card card-custom video-card">
                        <div class="video-thumbnail">
                            <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='400' height='200' viewBox='0 0 400 200'><rect width='400' height='200' fill='%23f7f6f4'/><rect x='50' y='50' width='300' height='100' fill='%232c7a7b' rx='8'/><text x='200' y='105' text-anchor='middle' fill='white' font-family='Arial' font-size='16' font-weight='bold'>درس في العقيدة</text></svg>" alt="درس في العقيدة">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <div class="video-content">
                            <h6 class="video-title">أسماء الله الحسنى وصفاته العلى</h6>
                            <p class="video-teacher">د. عبد الله الحسن</p>
                            <a href="#" class="btn btn-teal btn-sm">مشاهدة الدرس</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                    <div class="card card-custom video-card">
                        <div class="video-thumbnail">
                            <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='400' height='200' viewBox='0 0 400 200'><rect width='400' height='200' fill='%23f7f6f4'/><rect x='50' y='50' width='300' height='100' fill='%23d4a853' rx='8'/><text x='200' y='105' text-anchor='middle' fill='white' font-family='Arial' font-size='16' font-weight='bold'>درس في السيرة</text></svg>" alt="درس في السيرة">
                            <div class="play-button">
                                <i class="fas fa-play"></i>
                            </div>
                        </div>
                        <div class="video-content">
                            <h6 class="video-title">من دروس السيرة النبوية الشريفة</h6>
                            <p class="video-teacher">د. أحمد الطيب</p>
                            <a href="#" class="btn btn-teal btn-sm">مشاهدة الدرس</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4 fade-in-up">
                <a href="#" class="btn btn-gold btn-lg">
                    <i class="fas fa-video me-2"></i>
                    تصفح جميع الدروس
                </a>
            </div>
        </div>
    </section>

    <!-- Articles Section -->
    <section id="articles" class="section" style="background-color: var(--light-gray);">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center fade-in-up">
                    <h2 class="section-title arabic-font">المقالات والبحوث</h2>
                    <p class="section-subtitle">مقالات علمية وبحوث متخصصة في العلوم الشرعية</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                    <div class="card card-custom">
                        <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='400' height='200' viewBox='0 0 400 200'><rect width='400' height='200' fill='%23f7f6f4'/><rect x='50' y='50' width='300' height='100' fill='%23d4a853' rx='8'/><text x='200' y='105' text-anchor='middle' fill='white' font-family='Arial' font-size='14' font-weight='bold'>مقال في الفقه</text></svg>" class="card-img-top" alt="مقال في الفقه">
                        <div class="card-body">
                            <h6 class="card-title">أحكام الزكاة في الفقه الإسلامي</h6>
                            <p class="text-muted mb-2">د. محمد الأحمد</p>
                            <p class="card-text">بحث شامل في أحكام الزكاة وشروطها ومقاديرها وفق المذاهب الفقهية...</p>
                            <a href="#" class="btn btn-teal btn-sm">قراءة المقال</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                    <div class="card card-custom">
                        <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='400' height='200' viewBox='0 0 400 200'><rect width='400' height='200' fill='%23f7f6f4'/><rect x='50' y='50' width='300' height='100' fill='%232c7a7b' rx='8'/><text x='200' y='105' text-anchor='middle' fill='white' font-family='Arial' font-size='14' font-weight='bold'>مقال في العقيدة</text></svg>" class="card-img-top" alt="مقال في العقيدة">
                        <div class="card-body">
                            <h6 class="card-title">التوحيد ومراتبه في العقيدة الإسلامية</h6>
                            <p class="text-muted mb-2">د. عبد الله الحسن</p>
                            <p class="card-text">دراسة مفصلة في أنواع التوحيد الثلاثة وأهميتها في حياة المسلم...</p>
                            <a href="#" class="btn btn-teal btn-sm">قراءة المقال</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                    <div class="card card-custom">
                        <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='400' height='200' viewBox='0 0 400 200'><rect width='400' height='200' fill='%23f7f6f4'/><rect x='50' y='50' width='300' height='100' fill='%23d4a853' rx='8'/><text x='200' y='105' text-anchor='middle' fill='white' font-family='Arial' font-size='14' font-weight='bold'>مقال في السلوك</text></svg>" class="card-img-top" alt="مقال في السلوك">
                        <div class="card-body">
                            <h6 class="card-title">الأخلاق الإسلامية وتطبيقها العملي</h6>
                            <p class="text-muted mb-2">د. يوسف العلي</p>
                            <p class="card-text">كيفية تطبيق الأخلاق الإسلامية في الحياة اليومية والتعامل مع الناس...</p>
                            <a href="#" class="btn btn-teal btn-sm">قراءة المقال</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4 fade-in-up">
                <a href="#" class="btn btn-gold btn-lg">
                    <i class="fas fa-book me-2"></i>
                    تصفح جميع المقالات
                </a>
            </div>
        </div>
    </section>

    <!-- Library Section -->
    <section id="library" class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center fade-in-up">
                    <h2 class="section-title arabic-font">المكتبة الرقمية</h2>
                    <p class="section-subtitle">مجموعة من أهم الكتب والمراجع في العلوم الشرعية</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-3 col-md-6 mb-4 fade-in-up">
                    <div class="card card-custom text-center">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="fas fa-book" style="font-size: 4rem; color: var(--gold);"></i>
                            </div>
                            <h6 class="card-title">كتاب التوحيد</h6>
                            <p class="text-muted mb-2">محمد بن عبد الوهاب</p>
                            <p class="card-text">الكتاب الذي يحرر العبد من الشرك والبدع...</p>
                            <a href="#" class="btn btn-teal btn-sm">تفاصيل الكتاب</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 fade-in-up">
                    <div class="card card-custom text-center">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="fas fa-book-open" style="font-size: 4rem; color: var(--teal);"></i>
                            </div>
                            <h6 class="card-title">بلوغ المرام</h6>
                            <p class="text-muted mb-2">ابن حجر العسقلاني</p>
                            <p class="card-text">مجموعة من أحاديث الأحكام الفقهية...</p>
                            <a href="#" class="btn btn-teal btn-sm">تفاصيل الكتاب</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 fade-in-up">
                    <div class="card card-custom text-center">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="fas fa-book" style="font-size: 4rem; color: var(--gold);"></i>
                            </div>
                            <h6 class="card-title">العقيدة الطحاوية</h6>
                            <p class="text-muted mb-2">أبو جعفر الطحاوي</p>
                            <p class="card-text">بيان عقيدة أهل السنة والجماعة...</p>
                            <a href="#" class="btn btn-teal btn-sm">تفاصيل الكتاب</a>
                        </div>
                    </div>
                </div>
                <div class="col-lg-3 col-md-6 mb-4 fade-in-up">
                    <div class="card card-custom text-center">
                        <div class="card-body p-4">
                            <div class="mb-3">
                                <i class="fas fa-book-open" style="font-size: 4rem; color: var(--teal);"></i>
                            </div>
                            <h6 class="card-title">رياض الصالحين</h6>
                            <p class="text-muted mb-2">الإمام النووي</p>
                            <p class="card-text">مجموعة من الأحاديث في الآداب والأخلاق...</p>
                            <a href="#" class="btn btn-teal btn-sm">تفاصيل الكتاب</a>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4 fade-in-up">
                <a href="#" class="btn btn-gold btn-lg">
                    <i class="fas fa-library me-2"></i>
                    تصفح المكتبة الكاملة
                </a>
            </div>
        </div>
    </section>

    <!-- Gallery Section -->
    <section id="gallery" class="section" style="background-color: var(--light-gray);">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center fade-in-up">
                    <h2 class="section-title arabic-font">معرض الصور</h2>
                    <p class="section-subtitle">لقطات من فعالياتنا وأنشطتنا التعليمية</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                    <div class="gallery-item">
                        <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='400' height='250' viewBox='0 0 400 250'><rect width='400' height='250' fill='%23f7f6f4'/><rect x='50' y='50' width='300' height='150' fill='%23d4a853' rx='8'/><text x='200' y='130' text-anchor='middle' fill='white' font-family='Arial' font-size='16' font-weight='bold'>محاضرة علمية</text></svg>" alt="محاضرة علمية">
                        <div class="gallery-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                    <div class="gallery-item">
                        <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='400' height='250' viewBox='0 0 400 250'><rect width='400' height='250' fill='%23f7f6f4'/><rect x='50' y='50' width='300' height='150' fill='%232c7a7b' rx='8'/><text x='200' y='130' text-anchor='middle' fill='white' font-family='Arial' font-size='16' font-weight='bold'>ورشة تعليمية</text></svg>" alt="ورشة تعليمية">
                        <div class="gallery-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                    <div class="gallery-item">
                        <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='400' height='250' viewBox='0 0 400 250'><rect width='400' height='250' fill='%23f7f6f4'/><rect x='50' y='50' width='300' height='150' fill='%23d4a853' rx='8'/><text x='200' y='130' text-anchor='middle' fill='white' font-family='Arial' font-size='16' font-weight='bold'>لقاء طلابي</text></svg>" alt="لقاء طلابي">
                        <div class="gallery-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                    <div class="gallery-item">
                        <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='400' height='250' viewBox='0 0 400 250'><rect width='400' height='250' fill='%23f7f6f4'/><rect x='50' y='50' width='300' height='150' fill='%232c7a7b' rx='8'/><text x='200' y='130' text-anchor='middle' fill='white' font-family='Arial' font-size='16' font-weight='bold'>مؤتمر علمي</text></svg>" alt="مؤتمر علمي">
                        <div class="gallery-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                    <div class="gallery-item">
                        <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='400' height='250' viewBox='0 0 400 250'><rect width='400' height='250' fill='%23f7f6f4'/><rect x='50' y='50' width='300' height='150' fill='%23d4a853' rx='8'/><text x='200' y='130' text-anchor='middle' fill='white' font-family='Arial' font-size='16' font-weight='bold'>حفل تخرج</text></svg>" alt="حفل تخرج">
                        <div class="gallery-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
                <div class="col-lg-4 col-md-6 mb-4 fade-in-up">
                    <div class="gallery-item">
                        <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='400' height='250' viewBox='0 0 400 250'><rect width='400' height='250' fill='%23f7f6f4'/><rect x='50' y='50' width='300' height='150' fill='%232c7a7b' rx='8'/><text x='200' y='130' text-anchor='middle' fill='white' font-family='Arial' font-size='16' font-weight='bold'>فعالية خيرية</text></svg>" alt="فعالية خيرية">
                        <div class="gallery-overlay">
                            <i class="fas fa-search-plus"></i>
                        </div>
                    </div>
                </div>
            </div>
            <div class="text-center mt-4 fade-in-up">
                <a href="#" class="btn btn-gold btn-lg">
                    <i class="fas fa-images me-2"></i>
                    عرض جميع الصور
                </a>
            </div>
        </div>
    </section>

    <!-- Partners Section -->
    <section id="partners" class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center fade-in-up">
                    <h2 class="section-title arabic-font">شركاؤنا</h2>
                    <p class="section-subtitle">المؤسسات والجهات التي نتعاون معها</p>
                </div>
            </div>
            <div class="row align-items-center">
                <div class="col-lg-2 col-md-4 col-6 mb-4 text-center fade-in-up">
                    <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='150' height='80' viewBox='0 0 150 80'><rect width='150' height='80' fill='%23e2e8f0' rx='8'/><text x='75' y='45' text-anchor='middle' fill='%23718096' font-family='Arial' font-size='12'>شريك 1</text></svg>" 
                         alt="شريك 1" class="partner-logo">
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-4 text-center fade-in-up">
                    <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='150' height='80' viewBox='0 0 150 80'><rect width='150' height='80' fill='%23e2e8f0' rx='8'/><text x='75' y='45' text-anchor='middle' fill='%23718096' font-family='Arial' font-size='12'>شريك 2</text></svg>" 
                         alt="شريك 2" class="partner-logo">
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-4 text-center fade-in-up">
                    <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='150' height='80' viewBox='0 0 150 80'><rect width='150' height='80' fill='%23e2e8f0' rx='8'/><text x='75' y='45' text-anchor='middle' fill='%23718096' font-family='Arial' font-size='12'>شريك 3</text></svg>" 
                         alt="شريك 3" class="partner-logo">
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-4 text-center fade-in-up">
                    <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='150' height='80' viewBox='0 0 150 80'><rect width='150' height='80' fill='%23e2e8f0' rx='8'/><text x='75' y='45' text-anchor='middle' fill='%23718096' font-family='Arial' font-size='12'>شريك 4</text></svg>" 
                         alt="شريك 4" class="partner-logo">
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-4 text-center fade-in-up">
                    <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='150' height='80' viewBox='0 0 150 80'><rect width='150' height='80' fill='%23e2e8f0' rx='8'/><text x='75' y='45' text-anchor='middle' fill='%23718096' font-family='Arial' font-size='12'>شريك 5</text></svg>" 
                         alt="شريك 5" class="partner-logo">
                </div>
                <div class="col-lg-2 col-md-4 col-6 mb-4 text-center fade-in-up">
                    <img src="data:image/svg+xml,<svg xmlns='http://www.w3.org/2000/svg' width='150' height='80' viewBox='0 0 150 80'><rect width='150' height='80' fill='%23e2e8f0' rx='8'/><text x='75' y='45' text-anchor='middle' fill='%23718096' font-family='Arial' font-size='12'>شريك 6</text></svg>" 
                         alt="شريك 6" class="partner-logo">
                </div>
            </div>
        </div>
    </section>

    <!-- Announcements Section -->
    <section id="announcements" class="section" style="background-color: var(--light-gray);">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center fade-in-up">
                    <h2 class="section-title arabic-font">الأخبار والإعلانات</h2>
                    <p class="section-subtitle">آخر الأخبار والإعلانات المهمة</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="news-item fade-in-up">
                        <div class="news-date">15 جمادى الآخرة 1446</div>
                        <h5 class="news-title">افتتاح دورة جديدة في شرح العقيدة الطحاوية</h5>
                        <p class="news-excerpt">نعلن عن بدء التسجيل في دورة شرح العقيدة الطحاوية مع فضيلة الدكتور عبد الله الحسن...</p>
                        <a href="#" class="btn btn-teal btn-sm">قراءة المزيد</a>
                    </div>
                    
                    <div class="news-item fade-in-up">
                        <div class="news-date">10 جمادى الآخرة 1446</div>
                        <h5 class="news-title">انطلاق مؤتمر العلوم الشرعية السنوي</h5>
                        <p class="news-excerpt">يسر معهد أنوار العلوم أن يعلن عن انطلاق مؤتمر العلوم الشرعية السنوي بمشاركة نخبة من العلماء...</p>
                        <a href="#" class="btn btn-teal btn-sm">قراءة المزيد</a>
                    </div>
                    
                    <div class="news-item fade-in-up">
                        <div class="news-date">5 جمادى الآخرة 1446</div>
                        <h5 class="news-title">إطلاق المكتبة الرقمية الجديدة</h5>
                        <p class="news-excerpt">تم إطلاق المكتبة الرقمية الجديدة والتي تحتوي على مئات الكتب والمراجع في العلوم الشرعية...</p>
                        <a href="#" class="btn btn-teal btn-sm">قراءة المزيد</a>
                    </div>
                    
                    <div class="text-center mt-4 fade-in-up">
                        <a href="#" class="btn btn-gold btn-lg">
                            <i class="fas fa-newspaper me-2"></i>
                            تصفح جميع الأخبار والإعلانات
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Contact Section -->
    <section id="contact" class="section">
        <div class="container">
            <div class="row">
                <div class="col-12 text-center fade-in-up">
                    <h2 class="section-title arabic-font">تواصل معنا</h2>
                    <p class="section-subtitle">نحن هنا للإجابة على استفساراتكم ومساعدتكم</p>
                </div>
            </div>
            <div class="row">
                <div class="col-lg-8 mx-auto">
                    <div class="contact-form fade-in-up">
                        <form>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <label for="name" class="form-label">الاسم الكامل</label>
                                    <input type="text" class="form-control" id="name" required>
                                </div>
                                <div class="col-md-6 mb-3">
                                    <label for="email" class="form-label">البريد الإلكتروني</label>
                                    <input type="email" class="form-control" id="email" required>
                                </div>
                            </div>
                            <div class="mb-3">
                                <label for="subject" class="form-label">الموضوع</label>
                                <input type="text" class="form-control" id="subject" required>
                            </div>
                            <div class="mb-3">
                                <label for="message" class="form-label">الرسالة</label>
                                <textarea class="form-control" id="message" rows="5" required></textarea>
                            </div>
                            <div class="text-center">
                                <button type="submit" class="btn btn-gold btn-lg">
                                    <i class="fas fa-paper-plane me-2"></i>
                                    إرسال الرسالة
                                </button>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            
            <div class="row mt-5">
                <div class="col-lg-4 mb-4 text-center fade-in-up">
                    <div class="contact-info">
                        <div class="mb-3">
                            <i class="fas fa-map-marker-alt" style="font-size: 2rem; color: var(--gold);"></i>
                        </div>
                        <h5>العنوان</h5>
                        <p class="text-muted">شارع الملك فهد، الرياض<br>المملكة العربية السعودية</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4 text-center fade-in-up">
                    <div class="contact-info">
                        <div class="mb-3">
                            <i class="fas fa-envelope" style="font-size: 2rem; color: var(--teal);"></i>
                        </div>
                        <h5>البريد الإلكتروني</h5>
                        <p class="text-muted">info@anwaraloloma.com<br>contact@anwaraloloma.com</p>
                    </div>
                </div>
                <div class="col-lg-4 mb-4 text-center fade-in-up">
                    <div class="contact-info">
                        <div class="mb-3">
                            <i class="fas fa-phone" style="font-size: 2rem; color: var(--gold);"></i>
                        </div>
                        <h5>رقم الهاتف</h5>
                        <p class="text-muted">+966 11 234 5678<br>+966 50 123 4567</p>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- Footer -->
    <footer class="footer">
        <div class="container">
            <div class="row">
                <div class="col-lg-4 mb-4">
                    <div class="footer-brand mb-4">
                        <div class="logo-dome mb-3">
                            <i class="fas fa-mosque"></i>
                        </div>
                        <h4 class="arabic-font" style="color: var(--gold);">أنوار العلوم</h4>
                        <p class="mt-3">قناة متخصصة في نشر منهج أهل السنة: فقه وعقيدة وسلوك. نسعى لنشر العلم الشرعي الصحيح وتربية الأجيال على منهج السلف الصالح.</p>
                    </div>
                    <div class="social-links">
                        <a href="#" class="social-youtube me-2">
                            <i class="fab fa-youtube"></i>
                        </a>
                        <a href="#" class="social-facebook me-2">
                            <i class="fab fa-facebook-f"></i>
                        </a>
                        <a href="#" class="social-twitter me-2">
                            <i class="fab fa-twitter"></i>
                        </a>
                    </div>
                </div>
                
                <div class="col-lg-2 col-md-3 mb-4">
                    <h5>روابط سريعة</h5>
                    <ul class="list-unstyled">
                        <li><a href="#home">الرئيسية</a></li>
                        <li><a href="#about">عن القناة</a></li>
                        <li><a href="#teachers">المعلمون</a></li>
                        <li><a href="#videos">الدروس</a></li>
                        <li><a href="#articles">المقالات</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-3 mb-4">
                    <h5>الخدمات</h5>
                    <ul class="list-unstyled">
                        <li><a href="#library">المكتبة</a></li>
                        <li><a href="#gallery">المعرض</a></li>
                        <li><a href="#partners">الشراكات</a></li>
                        <li><a href="#announcements">الإعلانات</a></li>
                        <li><a href="#contact">التواصل</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-3 mb-4">
                    <h5>المعلومات القانونية</h5>
                    <ul class="list-unstyled">
                        <li><a href="#">سياسة الخصوصية</a></li>
                        <li><a href="#">شروط الاستخدام</a></li>
                        <li><a href="#">إخلاء المسؤولية</a></li>
                        <li><a href="#">اتفاقية الخدمة</a></li>
                    </ul>
                </div>
                
                <div class="col-lg-2 col-md-3 mb-4">
                    <h5>تواصل معنا</h5>
                    <div class="contact-info">
                        <p><i class="fas fa-envelope me-2" style="color: var(--gold);"></i> info@anwaraloloma.com</p>
                        <p><i class="fas fa-phone me-2" style="color: var(--gold);"></i> +966 11 234 5678</p>
                        <p><i class="fas fa-map-marker-alt me-2" style="color: var(--gold);"></i> الرياض، السعودية</p>
                    </div>
                </div>
            </div>
            
            <div class="footer-bottom">
                <p>&copy; 2025 أنوار العلوم. جميع الحقوق محفوظة.</p>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Navbar scroll effect
        window.addEventListener('scroll', function() {
            const navbar = document.querySelector('.navbar-custom');
            if (window.scrollY > 50) {
                navbar.classList.add('scrolled');
            } else {
                navbar.classList.remove('scrolled');
            }
        });

        // Smooth scrolling for navigation links
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    const offsetTop = target.offsetTop - 80;
                    window.scrollTo({
                        top: offsetTop,
                        behavior: 'smooth'
                    });
                }
            });
        });

        // Fade in animation on scroll
        const observerOptions = {
            threshold: 0.1,
            rootMargin: '0px 0px -50px 0px'
        };

        const observer = new IntersectionObserver(function(entries) {
            entries.forEach(entry => {
                if (entry.isIntersecting) {
                    entry.target.classList.add('visible');
                }
            });
        }, observerOptions);

        // Observe all fade-in-up elements
        document.querySelectorAll('.fade-in-up').forEach(el => {
            observer.observe(el);
        });

        // Active navigation link
        window.addEventListener('scroll', function() {
            const sections = document.querySelectorAll('section[id]');
            const navLinks = document.querySelectorAll('.nav-link');
            
            let current = '';
            sections.forEach(section => {
                const sectionTop = section.offsetTop - 100;
                const sectionHeight = section.clientHeight;
                if (window.scrollY >= sectionTop && window.scrollY < sectionTop + sectionHeight) {
                    current = section.getAttribute('id');
                }
            });

            navLinks.forEach(link => {
                link.classList.remove('active');
                if (link.getAttribute('href') === '#' + current) {
                    link.classList.add('active');
                }
            });
        });

        // Form submission
        document.querySelector('form').addEventListener('submit', function(e) {
            e.preventDefault();
            alert('تم إرسال رسالتك بنجاح! سنتواصل معك قريباً إن شاء الله.');
            this.reset();
        });
    </script>
</body>
</html>
<?php /**PATH C:\Users\osaid\BasmahApp\resources\views/welcome-premium.blade.php ENDPATH**/ ?>