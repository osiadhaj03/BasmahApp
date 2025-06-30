@extends('layouts.app')

@section('title', 'تسجيل طالب جديد - أنوار العلوم')

@section('styles')
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
        background: linear-gradient(135deg, var(--off-white) 0%, var(--light-gray) 100%);
        font-family: 'Cairo', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        min-height: 100vh;
    }

    .registration-container {
        min-height: 100vh;
        display: flex;
        align-items: center;
        padding: 2rem 0;
    }

    .registration-card {
        background: white;
        border-radius: var(--border-radius);
        box-shadow: var(--shadow-lg);
        border: none;
        overflow: hidden;
        max-width: 500px;
        margin: 0 auto;
    }

    .card-header-islamic {
        background: linear-gradient(135deg, var(--teal), var(--teal-light));
        color: white;
        padding: 2rem;
        text-align: center;
        position: relative;
    }

    .card-header-islamic::before {
        content: '';
        position: absolute;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-image: 
            repeating-linear-gradient(45deg, transparent, transparent 10px, rgba(255, 255, 255, 0.1) 10px, rgba(255, 255, 255, 0.1) 20px);
        pointer-events: none;
    }

    .islamic-logo {
        width: 60px;
        height: 60px;
        background: linear-gradient(135deg, var(--gold), var(--gold-light));
        border-radius: 50%;
        display: flex;
        align-items: center;
        justify-content: center;
        margin: 0 auto 1rem;
        font-size: 1.5rem;
        color: white;
        position: relative;
        overflow: hidden;
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

    .form-label {
        color: var(--teal-dark);
        font-weight: 600;
        margin-bottom: 0.5rem;
    }

    .form-control {
        border: 2px solid #e2e8f0;
        border-radius: var(--border-radius);
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
        padding: 12px 30px;
        border-radius: var(--border-radius);
        transition: var(--transition);
        box-shadow: var(--shadow);
        position: relative;
        overflow: hidden;
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

    .card-footer-islamic {
        background: var(--light-gray);
        border-top: 1px solid rgba(212, 168, 83, 0.2);
        padding: 1.5rem;
        text-align: center;
    }

    .link-islamic {
        color: var(--teal);
        text-decoration: none;
        font-weight: 600;
        transition: var(--transition);
    }

    .link-islamic:hover {
        color: var(--gold);
        text-decoration: underline;
    }

    .invalid-feedback {
        color: #dc3545;
        font-size: 0.875rem;
        margin-top: 0.25rem;
    }

    .is-invalid {
        border-color: #dc3545;
    }

    .text-islamic {
        color: var(--teal-dark);
    }

    .text-muted-islamic {
        color: var(--teal);
        opacity: 0.8;
    }
</style>
@endsection

@section('content')
<div class="registration-container">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-md-6">
                <div class="card registration-card">
                    <div class="card-header-islamic">
                        <div class="islamic-logo">
                            <i class="fas fa-mosque"></i>
                        </div>
                        <h4 class="mb-0">تسجيل طالب جديد</h4>
                        <small class="opacity-75">انضم إلى معهد أنوار العلوم</small>
                    </div>
                <div class="card-body p-4">
                    <form method="POST" action="{{ route('student.register') }}">
                        @csrf

                        <!-- Name -->
                        <div class="mb-3">
                            <label for="name" class="form-label">
                                <i class="fas fa-user me-1 text-islamic"></i>
                                الاسم الكامل *
                            </label>
                            <input id="name" type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required 
                                   placeholder="أدخل اسمك الكامل">
                            @error('name')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Email -->
                        <div class="mb-3">
                            <label for="email" class="form-label">
                                <i class="fas fa-envelope me-1 text-islamic"></i>
                                البريد الإلكتروني *
                            </label>
                            <input id="email" type="email" 
                                   class="form-control @error('email') is-invalid @enderror" 
                                   name="email" 
                                   value="{{ old('email') }}" 
                                   required 
                                   placeholder="example@domain.com">
                            @error('email')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Student ID -->
                        <div class="mb-3">
                            <label for="student_id" class="form-label">
                                <i class="fas fa-id-card me-1 text-islamic"></i>
                                رقم الطالب (اختياري)
                            </label>
                            <input id="student_id" type="text" 
                                   class="form-control @error('student_id') is-invalid @enderror" 
                                   name="student_id" 
                                   value="{{ old('student_id') }}" 
                                   placeholder="أدخل رقمك الجامعي إن وجد">
                            @error('student_id')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Phone -->
                        <div class="mb-3">
                            <label for="phone" class="form-label">
                                <i class="fas fa-phone me-1 text-islamic"></i>
                                رقم الهاتف (اختياري)
                            </label>
                            <input id="phone" type="text" 
                                   class="form-control @error('phone') is-invalid @enderror" 
                                   name="phone" 
                                   value="{{ old('phone') }}" 
                                   placeholder="05xxxxxxxx">
                            @error('phone')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Password -->
                        <div class="mb-3">
                            <label for="password" class="form-label">
                                <i class="fas fa-lock me-1 text-islamic"></i>
                                كلمة المرور *
                            </label>
                            <input id="password" type="password" 
                                   class="form-control @error('password') is-invalid @enderror" 
                                   name="password" 
                                   required 
                                   placeholder="8 أحرف على الأقل">
                            @error('password')
                                <span class="invalid-feedback">{{ $message }}</span>
                            @enderror
                        </div>

                        <!-- Confirm Password -->
                        <div class="mb-3">
                            <label for="password_confirmation" class="form-label">
                                <i class="fas fa-lock me-1 text-islamic"></i>
                                تأكيد كلمة المرور *
                            </label>
                            <input id="password_confirmation" type="password" 
                                   class="form-control" 
                                   name="password_confirmation" 
                                   required 
                                   placeholder="أعد إدخال كلمة المرور">
                        </div>

                        <div class="d-grid gap-2 mt-4">
                            <button type="submit" class="btn btn-islamic btn-lg">
                                <i class="fas fa-user-plus me-2"></i>
                                إنشاء الحساب
                            </button>
                        </div>
                    </form>
                </div>
                <div class="card-footer-islamic">
                    <p class="mb-2 text-islamic">
                        لديك حساب بالفعل؟ 
                        <a href="{{ route('login') }}" class="link-islamic">
                            تسجيل الدخول
                        </a>
                    </p>
                    <hr style="border-color: rgba(212, 168, 83, 0.3);">
                    <p class="text-muted-islamic small mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        تسجيل الطلاب فقط - المعلمين يتم إنشاء حساباتهم من قبل الإدارة
                    </p>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
// تحسين تجربة المستخدم
document.addEventListener('DOMContentLoaded', function() {
    // تأكيد كلمة المرور
    const password = document.getElementById('password');
    const confirmPassword = document.getElementById('password_confirmation');
    
    function validatePassword() {
        if (password.value !== confirmPassword.value) {
            confirmPassword.setCustomValidity('كلمات المرور غير متطابقة');
        } else {
            confirmPassword.setCustomValidity('');
        }
    }
    
    password.addEventListener('change', validatePassword);
    confirmPassword.addEventListener('keyup', validatePassword);
});
</script>
@endsection
