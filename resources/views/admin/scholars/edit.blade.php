@extends('layouts.admin')

@section('title', 'تعديل العالم: ' . $scholar->name)

@section('content')
@php
    $breadcrumb = [
        ['title' => 'الرئيسية', 'url' => route('admin.dashboard')],
        ['title' => 'العلماء', 'url' => route('admin.scholars.index')],
        ['title' => 'تعديل: ' . $scholar->name, 'url' => '']
    ];
@endphp

<div class="d-flex justify-content-between align-items-center mb-4">
    <h2 class="mb-0">
        <i class="fas fa-edit text-warning me-2"></i>
        تعديل العالم: {{ $scholar->name }}
    </h2>
    <div class="btn-group">
        <a href="{{ route('admin.scholars.show', $scholar) }}" class="btn btn-outline-info">
            <i class="fas fa-eye me-2"></i>
            عرض
        </a>
        <a href="{{ route('admin.scholars.index') }}" class="btn btn-outline-secondary">
            <i class="fas fa-arrow-right me-2"></i>
            العودة للقائمة
        </a>
    </div>
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
                <form action="{{ route('admin.scholars.update', $scholar) }}" method="POST" enctype="multipart/form-data">
                    @csrf
                    @method('PUT')
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="name" class="form-label">اسم العالم *</label>
                            <input type="text" 
                                   class="form-control @error('name') is-invalid @enderror" 
                                   id="name" 
                                   name="name" 
                                   value="{{ old('name', $scholar->name) }}" 
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
                                   value="{{ old('birth_year', $scholar->birth_year) }}" 
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
                                   value="{{ old('death_year', $scholar->death_year) }}" 
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
                                   value="{{ old('nationality', $scholar->nationality) }}">
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
                                  required>{{ old('bio', $scholar->bio) }}</textarea>
                        @error('bio')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                    
                    <div class="mb-3">
                        <label for="detailed_bio" class="form-label">السيرة التفصيلية</label>
                        <textarea class="form-control @error('detailed_bio') is-invalid @enderror" 
                                  id="detailed_bio" 
                                  name="detailed_bio" 
                                  rows="6">{{ old('detailed_bio', $scholar->detailed_bio) }}</textarea>
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
                                   value="{{ old('website', $scholar->website) }}"
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
                                      placeholder="مثال: تويتر: @username, يوتيوب: channel_name">{{ old('social_links', $scholar->social_links) }}</textarea>
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
                                       {{ old('is_active', $scholar->is_active) ? 'checked' : '' }}>
                                <label class="form-check-label" for="is_active">
                                    نشط
                                </label>
                            </div>
                        </div>
                    </div>
                    
                    <div class="d-flex gap-2">
                        <button type="submit" class="btn btn-warning">
                            <i class="fas fa-save me-2"></i>
                            حفظ التعديلات
                        </button>
                        <a href="{{ route('admin.scholars.show', $scholar) }}" class="btn btn-outline-info">
                            <i class="fas fa-eye me-2"></i>
                            عرض
                        </a>
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
                @if($scholar->image)
                    <div class="text-center mb-3">
                        <img src="{{ $scholar->image_url }}" 
                             alt="{{ $scholar->name }}" 
                             class="img-fluid rounded" 
                             style="max-height: 200px;">
                        <div class="mt-2">
                            <small class="text-muted">الصورة الحالية</small>
                        </div>
                    </div>
                @endif
                
                <div class="mb-3">
                    <label for="image" class="form-label">
                        {{ $scholar->image ? 'تغيير الصورة' : 'اختر صورة' }}
                    </label>
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
                    <div class="mt-2">
                        <small class="text-muted">الصورة الجديدة</small>
                    </div>
                </div>
                
                @if($scholar->image)
                    <div class="mt-3">
                        <button type="button" 
                                class="btn btn-outline-danger btn-sm" 
                                onclick="removeImage()">
                            <i class="fas fa-trash me-1"></i>
                            حذف الصورة الحالية
                        </button>
                    </div>
                @endif
            </div>
        </div>
        
        <div class="card mt-3">
            <div class="card-header">
                <h5 class="card-title mb-0">
                    <i class="fas fa-chart-bar me-2"></i>
                    إحصائيات
                </h5>
            </div>
            <div class="card-body">
                <div class="row text-center">
                    <div class="col-6">
                        <div class="mb-2">
                            <div class="h4 text-primary mb-0">{{ $scholar->courses_count ?? 0 }}</div>
                            <small class="text-muted">الدورات</small>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="mb-2">
                            <div class="h4 text-success mb-0">{{ $scholar->lessons_count ?? 0 }}</div>
                            <small class="text-muted">الدروس</small>
                        </div>
                    </div>
                </div>
                
                <hr>
                
                <div class="small text-muted">
                    <div class="mb-1">
                        <i class="fas fa-calendar me-2"></i>
                        تاريخ الإضافة: {{ $scholar->created_at->format('Y/m/d') }}
                    </div>
                    <div>
                        <i class="fas fa-edit me-2"></i>
                        آخر تعديل: {{ $scholar->updated_at->format('Y/m/d') }}
                    </div>
                </div>
            </div>
        </div>
        
        @if($scholar->courses_count > 0)
            <div class="card mt-3">
                <div class="card-header">
                    <h5 class="card-title mb-0">
                        <i class="fas fa-exclamation-triangle text-warning me-2"></i>
                        تحذير
                    </h5>
                </div>
                <div class="card-body">
                    <p class="text-warning mb-0">
                        <i class="fas fa-info-circle me-1"></i>
                        هذا العالم مرتبط بـ {{ $scholar->courses_count }} دورة. 
                        لا يمكن حذفه إلا بعد حذف جميع الدورات المرتبطة به أولاً.
                    </p>
                </div>
            </div>
        @endif
    </div>
</div>

<!-- Remove Image Modal -->
<div class="modal fade" id="removeImageModal" tabindex="-1">
    <div class="modal-dialog">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">حذف الصورة</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
            </div>
            <div class="modal-body">
                <p>هل أنت متأكد من حذف صورة العالم؟</p>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">إلغاء</button>
                <form action="{{ route('admin.scholars.remove-image', $scholar) }}" method="POST" style="display: inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger">حذف الصورة</button>
                </form>
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

function removeImage() {
    new bootstrap.Modal(document.getElementById('removeImageModal')).show();
}

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
