@extends('layouts.admin')

@section('title', 'إضافة قسم جديد')

@section('content')
@php
    $breadcrumb = [
        ['title' => 'الرئيسية', 'url' => route('admin.dashboard')],
        ['title' => 'الأقسام', 'url' => route('admin.categories.index')],
        ['title' => 'إضافة قسم جديد', 'url' => '']
    ];
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">
        <i class="fas fa-plus text-success me-2"></i>
        إضافة قسم جديد
    </h2>
    <a href="{{ route('admin.categories.index') }}" class="btn btn-outline-secondary">
        <i class="fas fa-arrow-right me-2"></i>
        العودة للقائمة
    </a>
</div>

<div class="row">
    <div class="col-lg-8">
        <div class="card">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-tag me-2"></i>
                    معلومات القسم
                </h5>
            </div>
            <div class="card-body">
                <form action="{{ route('admin.categories.store') }}" method="POST">
                    @csrf
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">اسم القسم *</label>
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
                            <label for="slug" class="form-label">الرابط المختصر</label>
                            <input type="text" 
                                   class="form-control @error('slug') is-invalid @enderror" 
                                   id="slug" 
                                   name="slug" 
                                   value="{{ old('slug') }}"
                                   placeholder="سيتم إنشاؤه تلقائياً">
                            @error('slug')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                إذا تُرك فارغاً، سيتم إنشاؤه تلقائياً من الاسم
                            </div>
                        </div>
                    </div>
                    
                    <div class="mb-3">
                        <label for="description" class="form-label">وصف القسم *</label>
                        <textarea class="form-control @error('description') is-invalid @enderror" 
                                  id="description" 
                                  name="description" 
                                  rows="3" 
                                  required>{{ old('description') }}</textarea>
                        @error('description')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="icon" class="form-label">أيقونة القسم</label>
                            <div class="input-group">
                                <span class="input-group-text">
                                    <i id="iconPreview" class="{{ old('icon', 'fas fa-tag') }}"></i>
                                </span>
                                <input type="text" 
                                       class="form-control @error('icon') is-invalid @enderror" 
                                       id="icon" 
                                       name="icon" 
                                       value="{{ old('icon') }}"
                                       placeholder="fas fa-book">
                                @error('icon')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                مثال: fas fa-book, fas fa-mosque, fas fa-star
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="color" class="form-label">لون القسم</label>
                            <input type="color" 
                                   class="form-control form-control-color @error('color') is-invalid @enderror" 
                                   id="color" 
                                   name="color" 
                                   value="{{ old('color', '#007bff') }}">
                            @error('color')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="sort_order" class="form-label">ترتيب العرض</label>
                            <input type="number" 
                                   class="form-control @error('sort_order') is-invalid @enderror" 
                                   id="sort_order" 
                                   name="sort_order" 
                                   value="{{ old('sort_order', 0) }}" 
                                   min="0">
                            @error('sort_order')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            <div class="form-text">
                                <i class="fas fa-info-circle me-1"></i>
                                الرقم الأصغر يظهر أولاً
                            </div>
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <div class="form-check mt-4">
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
                            حفظ القسم
                        </button>
                        <a href="{{ route('admin.categories.index') }}" class="btn btn-secondary">
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
                    <i class="fas fa-eye me-2"></i>
                    معاينة القسم
                </h5>
            </div>
            <div class="card-body text-center">
                <div id="categoryPreview" class="p-4 border rounded">
                    <div class="mb-3">
                        <i id="previewIcon" 
                           class="fas fa-tag fa-3x" 
                           style="color: #007bff;"></i>
                    </div>
                    <h5 id="previewName">اسم القسم</h5>
                    <p id="previewDescription" class="text-muted">وصف القسم سيظهر هنا</p>
                    <span id="previewOrder" class="badge bg-secondary">الترتيب: 0</span>
                </div>
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-palette me-2"></i>
                    أيقونات مقترحة
                </h5>
            </div>
            <div class="card-body">
                <div class="row g-2">
                    <div class="col-4 text-center">
                        <button type="button" class="btn btn-outline-primary w-100 icon-btn" data-icon="fas fa-book">
                            <i class="fas fa-book"></i><br>
                            <small>كتاب</small>
                        </button>
                    </div>
                    <div class="col-4 text-center">
                        <button type="button" class="btn btn-outline-primary w-100 icon-btn" data-icon="fas fa-mosque">
                            <i class="fas fa-mosque"></i><br>
                            <small>مسجد</small>
                        </button>
                    </div>
                    <div class="col-4 text-center">
                        <button type="button" class="btn btn-outline-primary w-100 icon-btn" data-icon="fas fa-star">
                            <i class="fas fa-star"></i><br>
                            <small>نجمة</small>
                        </button>
                    </div>
                    <div class="col-4 text-center">
                        <button type="button" class="btn btn-outline-primary w-100 icon-btn" data-icon="fas fa-heart">
                            <i class="fas fa-heart"></i><br>
                            <small>قلب</small>
                        </button>
                    </div>
                    <div class="col-4 text-center">
                        <button type="button" class="btn btn-outline-primary w-100 icon-btn" data-icon="fas fa-graduation-cap">
                            <i class="fas fa-graduation-cap"></i><br>
                            <small>تعليم</small>
                        </button>
                    </div>
                    <div class="col-4 text-center">
                        <button type="button" class="btn btn-outline-primary w-100 icon-btn" data-icon="fas fa-quran">
                            <i class="fas fa-quran"></i><br>
                            <small>قرآن</small>
                        </button>
                    </div>
                    <div class="col-4 text-center">
                        <button type="button" class="btn btn-outline-primary w-100 icon-btn" data-icon="fas fa-praying-hands">
                            <i class="fas fa-praying-hands"></i><br>
                            <small>دعاء</small>
                        </button>
                    </div>
                    <div class="col-4 text-center">
                        <button type="button" class="btn btn-outline-primary w-100 icon-btn" data-icon="fas fa-moon">
                            <i class="fas fa-moon"></i><br>
                            <small>هلال</small>
                        </button>
                    </div>
                    <div class="col-4 text-center">
                        <button type="button" class="btn btn-outline-primary w-100 icon-btn" data-icon="fas fa-hands">
                            <i class="fas fa-hands"></i><br>
                            <small>يدين</small>
                        </button>
                    </div>
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
                        اختر اسماً واضحاً ومفهوماً للقسم
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        اكتب وصفاً مختصراً وجذاباً
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        اختر أيقونة مناسبة للموضوع
                    </li>
                    <li class="mb-2">
                        <i class="fas fa-check text-success me-2"></i>
                        حدد ترتيب العرض حسب الأولوية
                    </li>
                    <li>
                        <i class="fas fa-check text-success me-2"></i>
                        تأكد من تفعيل القسم ليظهر في الموقع
                    </li>
                </ul>
            </div>
        </div>
    </div>
</div>

@endsection

@push('scripts')
<script>
// Auto-generate slug from name
document.getElementById('name').addEventListener('input', function() {
    const name = this.value;
    const slug = name.toLowerCase()
                    .replace(/[أإآ]/g, 'ا')
                    .replace(/[ة]/g, 'ه')
                    .replace(/[ى]/g, 'ي')
                    .replace(/[ئ]/g, 'ي')
                    .replace(/[ء]/g, '')
                    .replace(/[\s]+/g, '-')
                    .replace(/[^\u0600-\u06FF\u0750-\u077F\u08A0-\u08FF\uFB50-\uFDFF\uFE70-\uFEFFa-z0-9\-]/g, '')
                    .replace(/\-+/g, '-')
                    .replace(/^\-|\-$/g, '');
    
    if (!document.getElementById('slug').value) {
        document.getElementById('slug').value = slug;
    }
    
    // Update preview
    document.getElementById('previewName').textContent = name || 'اسم القسم';
});

// Update description preview
document.getElementById('description').addEventListener('input', function() {
    const description = this.value;
    document.getElementById('previewDescription').textContent = description || 'وصف القسم سيظهر هنا';
});

// Update icon preview
function updateIconPreview() {
    const icon = document.getElementById('icon').value || 'fas fa-tag';
    const color = document.getElementById('color').value;
    
    document.getElementById('iconPreview').className = icon;
    document.getElementById('previewIcon').className = icon + ' fa-3x';
    document.getElementById('previewIcon').style.color = color;
}

document.getElementById('icon').addEventListener('input', updateIconPreview);
document.getElementById('color').addEventListener('input', updateIconPreview);

// Update sort order preview
document.getElementById('sort_order').addEventListener('input', function() {
    const order = this.value || '0';
    document.getElementById('previewOrder').textContent = 'الترتيب: ' + order;
});

// Icon selection buttons
document.querySelectorAll('.icon-btn').forEach(button => {
    button.addEventListener('click', function() {
        const icon = this.getAttribute('data-icon');
        document.getElementById('icon').value = icon;
        updateIconPreview();
    });
});

// Initialize preview
updateIconPreview();
</script>
@endpush
