@extends('layouts.app')

@section('title', 'تسجيل طالب جديد')

@section('content')
<div class="text-center mb-4">
    <div class="mb-3">
        <i class="fas fa-user-plus text-gradient" style="font-size: 3rem;"></i>
    </div>
    <h2 class="text-gradient mb-2">تسجيل طالب جديد</h2>
    <p class="text-muted" style="color: var(--islamic-dark-teal) !important;">أنشئ حسابك للانضمام إلى منصة أنوار العلوم</p>
</div>

<!-- Error messages -->
@if ($errors->any())
    <div class="alert alert-danger alert-custom mb-4">
        <i class="fas fa-exclamation-triangle me-2"></i>
        <strong>يرجى تصحيح الأخطاء التالية:</strong>
        <ul class="mb-0 mt-2">
            @foreach ($errors->all() as $error)
                <li>{{ $error }}</li>
            @endforeach
        </ul>
    </div>
@endif

<form method="POST" action="{{ route('student.register') }}" autocomplete="off">
    @csrf

    <!-- Name -->
    <div class="mb-3">
        <label for="name" class="form-label">
            <i class="fas fa-user me-1"></i>
            الاسم الكامل *
        </label>
        <input id="name" type="text" 
               class="form-control @error('name') is-invalid @enderror" 
               name="name" 
               value="{{ old('name') }}" 
               required 
               autocomplete="off"
               placeholder="أدخل اسمك الكامل">
        @error('name')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <!-- Email -->
    <div class="mb-3">
        <label for="email" class="form-label">
            <i class="fas fa-envelope me-1"></i>
            البريد الإلكتروني *
        </label>
        <input id="email" type="email" 
               class="form-control @error('email') is-invalid @enderror" 
               name="email" 
               value="{{ old('email') }}" 
               required 
               autocomplete="off"
               placeholder="example@domain.com">
        @error('email')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <!-- Password -->
    <div class="mb-3">
        <label for="password" class="form-label">
            <i class="fas fa-lock me-1"></i>
            كلمة المرور *
        </label>
        <input id="password" type="password" 
               class="form-control @error('password') is-invalid @enderror" 
               name="password" 
               required 
               autocomplete="new-password"
               placeholder="8 أحرف على الأقل">
        @error('password')
            <span class="invalid-feedback">{{ $message }}</span>
        @enderror
    </div>

    <!-- Confirm Password -->
    <div class="mb-3">
        <label for="password_confirmation" class="form-label">
            <i class="fas fa-lock me-1"></i>
            تأكيد كلمة المرور *
        </label>
        <input id="password_confirmation" type="password" 
               class="form-control" 
               name="password_confirmation" 
               required 
               autocomplete="new-password"
               placeholder="أعد إدخال كلمة المرور">
    </div>

    <div class="d-grid gap-2 mb-4">
        <button type="submit" class="btn btn-primary-custom btn-custom">
            <i class="fas fa-user-plus me-2"></i>
            إنشاء الحساب
        </button>
    </div>
</form>

<div class="text-center">
    <p class="mb-2">
        لديك حساب بالفعل؟ 
        <a href="{{ route('admin.login') }}" class="text-decoration-none" style="color: var(--islamic-gold); font-weight: 600;">
            تسجيل الدخول
        </a>
    </p>
    <hr style="border-color: var(--islamic-gold); opacity: 0.3;">
    <div class="alert-custom">
        <p class="text-muted small mb-0" style="color: var(--islamic-dark-teal) !important;">
            <i class="fas fa-info-circle me-1" style="color: var(--islamic-gold);"></i>
            <strong>مهم:</strong> تسجيل الطلاب فقط - المعلمين يتم إنشاء حساباتهم من قبل الإدارة
        </p>
    </div>
</div>
@endsection

@section('scripts')
<script>
// تحسين تجربة المستخدم ومنع auto-fill
document.addEventListener('DOMContentLoaded', function() {
    // منع auto-fill للحقول
    const inputs = document.querySelectorAll('input');
    inputs.forEach(input => {
        // مسح أي قيم محفوظة
        setTimeout(() => {
            if (!input.value || input.value === '') {
                input.value = '';
            }
        }, 100);
        
        // منع auto-complete
        input.setAttribute('autocomplete', 'off');
        input.setAttribute('data-lpignore', 'true'); // لـ LastPass
        input.setAttribute('data-form-type', 'other'); // لبرامج إدارة كلمات المرور
    });
    
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
    
    // تنظيف الحقول عند التحميل (لمنع auto-fill)
    setTimeout(() => {
        document.getElementById('email').value = '';
        document.getElementById('password').value = '';
        document.getElementById('password_confirmation').value = '';
    }, 500);
});
</script>
@endsection
