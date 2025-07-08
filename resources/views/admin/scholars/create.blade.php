@extends('layouts.admin')

@section('title', 'إضافة عالم جديد')

@section('content')
@php
    $breadcrumb = [
        ['title' => 'الرئيسية', 'url' => route('admin.dashboard')],
        ['title' => 'العلماء', 'url' => route('admin.scholars.index')],
        ['title' => 'إضافة عالم جديد', 'url' => '']
    ];
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">
        <i class="fas fa-plus text-success me-2"></i>
        إضافة عالم جديد
    </h2>
    <a href="{{ route('admin.scholars.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-right me-2"></i>
        العودة للقائمة
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-user-edit me-2"></i>
                    معلومات العالم
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.scholars.store') }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">اسم العالم *</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name') }}" 
                                   required>
                            @error('name')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="birth_year" class="form-label">سنة الميلاد (هجرية)</label>
                            <input type="number" 
                                   class="form-control @error('birth_year') is-invalid @enderror" 
                                   id="birth_year" 
                                   name="birth_year" 
                                   value="{{ old('birth_year') }}" 
                                   min="1" 
                                   max="1500">
                            @error('birth_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="death_year" class="form-label">سنة الوفاة (هجرية)</label>
                            <input type="number" 
                                   class="form-control @error('death_year') is-invalid @enderror" 
                                   id="death_year" 
                                   name="death_year" 
                                   value="{{ old('death_year') }}" 
                                   min="1" 
                                   max="1500">
                            @error('death_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="nationality" class="form-label">الجنسية</label>
                            <input type="text" 
                                   class="form-control @error('nationality') is-invalid @enderror" 
                                   id="nationality" 
                                   name="nationality" 
                                   value="{{ old('nationality') }}">
                            @error('nationality')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="bio" class="form-label">نبذة مختصرة *</label>
                        <textarea class="form-control @error('bio') is-invalid @enderror" 
                                  id="bio" 
                                  name="bio" 
                                  rows="3" 
                                  required>{{ old('bio') }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="detailed_bio" class="form-label">السيرة التفصيلية</label>
                        <textarea class="form-control @error('detailed_bio') is-invalid @enderror" 
                                  id="detailed_bio" 
                                  name="detailed_bio" 
                                  rows="6">{{ old('detailed_bio') }}</textarea>
                        @error('detailed_bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="website" class="form-label">الموقع الإلكتروني</label>
                            <input type="url" 
                                   class="form-control @error('website') is-invalid @enderror" 
                                   id="website" 
                                   name="website" 
                                   value="{{ old('website') }}"
                                   placeholder="https://example.com">
                            @error('website')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="social_links" class="form-label">الروابط الاجتماعية</label>
                            <textarea class="form-control @error('social_links') is-invalid @enderror" 
                                      id="social_links" 
                                      name="social_links" 
                                      rows="2"
                                      placeholder="مثال: تويتر: @username, يوتيوب: channel_name">{{ old('social_links') }}</textarea>
                            @error('social_links')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <div class="form-check">
                                <input class="form-check-input" 
                                       type="checkbox" 
                                       id="is_active" 
                                       name="is_active" 
                                       value="1" 
                                       {{ old('is_active', true) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    نشط
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-success">
                            <i class="fas fa-save me-2"></i>
                            حفظ العالم
                        </button>
                        <a href="{{ route('admin.scholars.index') }}" class="btn btn-secondary">
                            <i class="fas fa-times me-2"></i>
                            إلغاء
                        </a>
                    </div>
                </form>
            </div>
        </div>
    </div>
    
    <div class="col-lg-4">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-image me-2"></i>
                    صورة العالم
                </h5>
            </div>
            <div class="card-body">
                <div class="mb-3">
                    <label for="image" class="form-label">اختر صورة</label>
                    <input type="file" 
                           class="form-control @error('image') is-invalid @enderror" 
                           id="image" 
                           name="image" 
                           accept="image/*">
                    @error('image')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                    <div class="form-text">
                        <i class="fas fa-info-circle me-1"></i>
                        أحجام مقبولة: JPG, PNG, GIF (حد أقصى 2MB)
                    </div>
                </div>
                
                <div id="imagePreview" class="text-center" style="display: none;">
                    <img id="previewImg" src="" alt="معاينة الصورة" class="img-fluid rounded" style="max-height: 200px;">
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-lightbulb me-2"></i>
                    نصائح
                </h5>
            </div>
            <div class="card-body">
                <ul class="list-unstyled mb-0">
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        اختر اسماً واضحاً ومفهوماً للعالم
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        اكتب نبذة مختصرة وجذابة
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        أضف صورة عالية الجودة
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        املأ المعلومات الشخصية بدقة
                    </li>
                    <li>
                        <i class="fas fa-check text-success me-2"></i>
                        تأكد من تفعيل العالم ليظهر في الموقع
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
document.getElementById('image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    if (file) {
        const reader = new FileReader();
        reader.onload = function(e) {
            document.getElementById('previewImg').src = e.target.result;
            document.getElementById('imagePreview').style.display = 'block';
        };
        reader.readAsDataURL(file);
    } else {
        document.getElementById('imagePreview').style.display = 'none';
    }
});

// Validate death year is after birth year
document.getElementById('death_year').addEventListener('change', function() {
    const birthYear = parseInt(document.getElementById('birth_year').value);
    const deathYear = parseInt(this.value);
    
    if (birthYear && deathYear && deathYear <= birthYear) {
        alert('سنة الوفاة يجب أن تكون بعد سنة الميلاد');
        this.value = '';
    }
});

document.getElementById('birth_year').addEventListener('change', function() {
    const birthYear = parseInt(this.value);
    const deathYear = parseInt(document.getElementById('death_year').value);
    
    if (birthYear && deathYear && deathYear <= birthYear) {
        alert('سنة الوفاة يجب أن تكون بعد سنة الميلاد');
        document.getElementById('death_year').value = '';
    }
});
</script>
@endpush
