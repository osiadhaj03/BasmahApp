@extends('layouts.admin')

@section('title', isset($book) ? 'تعديل الكتاب' : 'إضافة كتاب جديد')

@push('styles')
<style>
    .form-section {
        background: rgba(255, 255, 255, 0.9);
        border: 1px solid rgba(212, 168, 83, 0.2);
        border-radius: 15px;
        padding: 25px;
        margin-bottom: 20px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.05);
    }
    .section-title {
        color: var(--islamic-teal);
        border-bottom: 2px solid var(--islamic-gold);
        padding-bottom: 10px;
        margin-bottom: 20px;
        font-weight: 600;
    }
    .form-control:focus {
        border-color: var(--islamic-gold);
        box-shadow: 0 0 0 0.2rem rgba(212, 168, 83, 0.25);
    }
    .cover-preview {
        max-width: 200px;
        max-height: 250px;
        border-radius: 10px;
        box-shadow: 0 4px 15px rgba(0,0,0,0.1);
    }
    .file-info {
        background: #f8f9fa;
        padding: 15px;
        border-radius: 10px;
        border: 2px dashed #dee2e6;
    }
    .switch {
        position: relative;
        display: inline-block;
        width: 60px;
        height: 34px;
    }
    .switch input {
        opacity: 0;
        width: 0;
        height: 0;
    }
    .slider {
        position: absolute;
        cursor: pointer;
        top: 0;
        left: 0;
        right: 0;
        bottom: 0;
        background-color: #ccc;
        transition: .4s;
        border-radius: 34px;
    }
    .slider:before {
        position: absolute;
        content: "";
        height: 26px;
        width: 26px;
        left: 4px;
        bottom: 4px;
        background-color: white;
        transition: .4s;
        border-radius: 50%;
    }
    input:checked + .slider {
        background-color: var(--islamic-gold);
    }
    input:checked + .slider:before {
        transform: translateX(26px);
    }
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h1 class="h3 mb-0">
            <i class="fas fa-book me-2 text-primary"></i>
            {{ isset($book) ? 'تعديل الكتاب' : 'إضافة كتاب جديد' }}
        </h1>
        <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
            <i class="fas fa-arrow-right me-2"></i>العودة للقائمة
        </a>
    </div>

    <form action="{{ isset($book) ? route('admin.books.update', $book) : route('admin.books.store') }}" 
          method="POST" 
          enctype="multipart/form-data">
        @csrf
        @if(isset($book))
            @method('PUT')
        @endif

        <div class="row">
            <div class="col-lg-8">
                <!-- Basic Information -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-info-circle me-2"></i>المعلومات الأساسية
                    </h4>
                    
                    <div class="row">
                        <div class="col-md-12 mb-3">
                            <label for="title" class="form-label">عنوان الكتاب <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('title') is-invalid @enderror" 
                                   id="title" 
                                   name="title" 
                                   value="{{ old('title', $book->title ?? '') }}" 
                                   required>
                            @error('title')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="author" class="form-label">المؤلف <span class="text-danger">*</span></label>
                            <input type="text" 
                                   class="form-control @error('author') is-invalid @enderror" 
                                   id="author" 
                                   name="author" 
                                   value="{{ old('author', $book->author ?? '') }}" 
                                   required>
                            @error('author')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="isbn" class="form-label">رقم ISBN</label>
                            <input type="text" 
                                   class="form-control @error('isbn') is-invalid @enderror" 
                                   id="isbn" 
                                   name="isbn" 
                                   value="{{ old('isbn', $book->isbn ?? '') }}">
                            @error('isbn')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="category" class="form-label">التصنيف <span class="text-danger">*</span></label>
                            <select class="form-select @error('category') is-invalid @enderror" 
                                    id="category" 
                                    name="category" 
                                    required>
                                <option value="">اختر التصنيف</option>
                                <option value="فقه" {{ old('category', $book->category ?? '') === 'فقه' ? 'selected' : '' }}>فقه</option>
                                <option value="عقيدة" {{ old('category', $book->category ?? '') === 'عقيدة' ? 'selected' : '' }}>عقيدة</option>
                                <option value="تفسير" {{ old('category', $book->category ?? '') === 'تفسير' ? 'selected' : '' }}>تفسير</option>
                                <option value="حديث" {{ old('category', $book->category ?? '') === 'حديث' ? 'selected' : '' }}>حديث</option>
                                <option value="سيرة" {{ old('category', $book->category ?? '') === 'سيرة' ? 'selected' : '' }}>سيرة</option>
                                <option value="أخلاق" {{ old('category', $book->category ?? '') === 'أخلاق' ? 'selected' : '' }}>أخلاق</option>
                                <option value="تاريخ" {{ old('category', $book->category ?? '') === 'تاريخ' ? 'selected' : '' }}>تاريخ</option>
                                <option value="أدب" {{ old('category', $book->category ?? '') === 'أدب' ? 'selected' : '' }}>أدب</option>
                            </select>
                            @error('category')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="language" class="form-label">اللغة</label>
                            <select class="form-select @error('language') is-invalid @enderror" 
                                    id="language" 
                                    name="language">
                                <option value="العربية" {{ old('language', $book->language ?? 'العربية') === 'العربية' ? 'selected' : '' }}>العربية</option>
                                <option value="الإنجليزية" {{ old('language', $book->language ?? '') === 'الإنجليزية' ? 'selected' : '' }}>الإنجليزية</option>
                                <option value="الفرنسية" {{ old('language', $book->language ?? '') === 'الفرنسية' ? 'selected' : '' }}>الفرنسية</option>
                                <option value="أخرى" {{ old('language', $book->language ?? '') === 'أخرى' ? 'selected' : '' }}>أخرى</option>
                            </select>
                            @error('language')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="publication_year" class="form-label">سنة النشر</label>
                            <input type="number" 
                                   class="form-control @error('publication_year') is-invalid @enderror" 
                                   id="publication_year" 
                                   name="publication_year" 
                                   value="{{ old('publication_year', $book->publication_year ?? '') }}"
                                   min="1400" 
                                   max="{{ date('Y') }}">
                            @error('publication_year')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="pages_count" class="form-label">عدد الصفحات</label>
                            <input type="number" 
                                   class="form-control @error('pages_count') is-invalid @enderror" 
                                   id="pages_count" 
                                   name="pages_count" 
                                   value="{{ old('pages_count', $book->pages_count ?? '') }}"
                                   min="1">
                            @error('pages_count')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                        
                        <div class="col-12 mb-3">
                            <label for="description" class="form-label">وصف الكتاب <span class="text-danger">*</span></label>
                            <textarea class="form-control @error('description') is-invalid @enderror" 
                                      id="description" 
                                      name="description" 
                                      rows="4" 
                                      required>{{ old('description', $book->description ?? '') }}</textarea>
                            @error('description')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>

                <!-- Files Section -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-file me-2"></i>الملفات والمرفقات
                    </h4>
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label for="cover_image" class="form-label">غلاف الكتاب</label>
                            <input type="file" 
                                   class="form-control @error('cover_image') is-invalid @enderror" 
                                   id="cover_image" 
                                   name="cover_image" 
                                   accept="image/*">
                            <small class="form-text text-muted">
                                الصيغ المدعومة: JPG, PNG, GIF. الحد الأقصى: 2MB
                            </small>
                            @error('cover_image')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @if(isset($book) && $book->cover_image)
                                <div class="mt-2">
                                    <img src="{{ Storage::url($book->cover_image) }}" 
                                         alt="غلاف الكتاب الحالي" 
                                         class="cover-preview">
                                    <p class="text-muted mt-1">الغلاف الحالي</p>
                                </div>
                            @endif
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label for="book_file" class="form-label">ملف الكتاب</label>
                            <input type="file" 
                                   class="form-control @error('book_file') is-invalid @enderror" 
                                   id="book_file" 
                                   name="book_file" 
                                   accept=".pdf,.doc,.docx,.epub">
                            <small class="form-text text-muted">
                                الصيغ المدعومة: PDF, DOC, DOCX, EPUB. الحد الأقصى: 50MB
                            </small>
                            @error('book_file')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                            
                            @if(isset($book) && $book->file_path)
                                <div class="file-info mt-2">
                                    <i class="fas fa-file-pdf text-danger me-2"></i>
                                    <strong>ملف موجود:</strong> {{ basename($book->file_path) }}
                                    <br>
                                    <small class="text-muted">
                                        الحجم: {{ $book->file_size ? number_format($book->file_size / 1024 / 1024, 1) . ' MB' : 'غير محدد' }}
                                    </small>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>

                <!-- SEO and Tags -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-tags me-2"></i>العلامات والكلمات المفتاحية
                    </h4>
                    
                    <div class="row">
                        <div class="col-12 mb-3">
                            <label for="tags" class="form-label">الكلمات المفتاحية</label>
                            <input type="text" 
                                   class="form-control @error('tags') is-invalid @enderror" 
                                   id="tags" 
                                   name="tags" 
                                   value="{{ old('tags', isset($book) && $book->tags ? implode(', ', $book->tags) : '') }}"
                                   placeholder="أدخل الكلمات المفتاحية مفصولة بفواصل">
                            <small class="form-text text-muted">
                                مثال: فقه, عبادات, صلاة, زكاة
                            </small>
                            @error('tags')
                                <div class="invalid-feedback">{{ $message }}</div>
                            @enderror
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-4">
                <!-- Publishing Options -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-cog me-2"></i>خيارات النشر
                    </h4>
                    
                    <div class="mb-3">
                        <label class="form-label d-flex align-items-center">
                            <span class="me-3">كتاب مميز</span>
                            <label class="switch">
                                <input type="checkbox" 
                                       name="is_featured" 
                                       value="1" 
                                       {{ old('is_featured', $book->is_featured ?? false) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </label>
                        <small class="form-text text-muted">
                            الكتب المميزة تظهر في المقدمة
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label d-flex align-items-center">
                            <span class="me-3">منشور</span>
                            <label class="switch">
                                <input type="checkbox" 
                                       name="is_published" 
                                       value="1" 
                                       {{ old('is_published', $book->is_published ?? true) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </label>
                        <small class="form-text text-muted">
                            غير المنشور لا يظهر للزوار
                        </small>
                    </div>
                    
                    <div class="mb-3">
                        <label class="form-label d-flex align-items-center">
                            <span class="me-3">قابل للتحميل</span>
                            <label class="switch">
                                <input type="checkbox" 
                                       name="is_downloadable" 
                                       value="1" 
                                       {{ old('is_downloadable', $book->is_downloadable ?? true) ? 'checked' : '' }}>
                                <span class="slider"></span>
                            </label>
                        </label>
                        <small class="form-text text-muted">
                            السماح بتحميل الكتاب
                        </small>
                    </div>
                </div>

                <!-- Rating Section -->
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-star me-2"></i>التقييم
                    </h4>
                    
                    <div class="mb-3">
                        <label for="rating" class="form-label">تقييم الكتاب</label>
                        <select class="form-select @error('rating') is-invalid @enderror" 
                                id="rating" 
                                name="rating">
                            <option value="">بدون تقييم</option>
                            <option value="1" {{ old('rating', $book->rating ?? '') == '1' ? 'selected' : '' }}>⭐ (1)</option>
                            <option value="2" {{ old('rating', $book->rating ?? '') == '2' ? 'selected' : '' }}>⭐⭐ (2)</option>
                            <option value="3" {{ old('rating', $book->rating ?? '') == '3' ? 'selected' : '' }}>⭐⭐⭐ (3)</option>
                            <option value="4" {{ old('rating', $book->rating ?? '') == '4' ? 'selected' : '' }}>⭐⭐⭐⭐ (4)</option>
                            <option value="5" {{ old('rating', $book->rating ?? '') == '5' ? 'selected' : '' }}>⭐⭐⭐⭐⭐ (5)</option>
                        </select>
                        @error('rating')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                    </div>
                </div>

                <!-- Statistics (for edit only) -->
                @if(isset($book))
                <div class="form-section">
                    <h4 class="section-title">
                        <i class="fas fa-chart-bar me-2"></i>الإحصائيات
                    </h4>
                    
                    <div class="row">
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h4 text-primary">{{ $book->download_count }}</div>
                                <small class="text-muted">تحميلات</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="text-center">
                                <div class="h4 text-success">{{ $book->created_at->diffForHumans() }}</div>
                                <small class="text-muted">تاريخ الإضافة</small>
                            </div>
                        </div>
                    </div>
                </div>
                @endif

                <!-- Action Buttons -->
                <div class="form-section">
                    <div class="d-grid gap-2">
                        <button type="submit" class="btn btn-primary btn-lg">
                            <i class="fas fa-save me-2"></i>
                            {{ isset($book) ? 'تحديث الكتاب' : 'حفظ الكتاب' }}
                        </button>
                        
                        @if(isset($book))
                            <a href="{{ route('admin.books.show', $book) }}" class="btn btn-outline-info">
                                <i class="fas fa-eye me-2"></i>معاينة الكتاب
                            </a>
                        @endif
                        
                        <a href="{{ route('admin.books.index') }}" class="btn btn-outline-secondary">
                            <i class="fas fa-times me-2"></i>إلغاء
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
// File size validation
document.getElementById('book_file').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const maxSize = 50 * 1024 * 1024; // 50MB
    
    if (file && file.size > maxSize) {
        alert('حجم الملف كبير جداً. الحد الأقصى المسموح 50 ميجابايت.');
        this.value = '';
    }
});

document.getElementById('cover_image').addEventListener('change', function(e) {
    const file = e.target.files[0];
    const maxSize = 2 * 1024 * 1024; // 2MB
    
    if (file && file.size > maxSize) {
        alert('حجم الصورة كبير جداً. الحد الأقصى المسموح 2 ميجابايت.');
        this.value = '';
    }
});

// Auto-slug generation
document.getElementById('title').addEventListener('input', function(e) {
    // You can add auto-slug generation here if needed
});
</script>
@endpush
