@extends('layouts.admin')

@section('title', 'تعديل الكتاب')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0 text-primary">
                <i class="fas fa-edit me-2"></i>
                تعديل الكتاب: {{ $book->title }}
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.books.index') }}">الكتب</a></li>
                    <li class="breadcrumb-item active">تعديل الكتاب</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">تفاصيل الكتاب</h5>
                    <div class="d-flex gap-2">
                        @if($book->is_published)
                            <span class="badge bg-success">منشور</span>
                        @else
                            <span class="badge bg-warning">مسودة</span>
                        @endif
                        @if($book->is_featured)
                            <span class="badge bg-warning">مميز</span>
                        @endif
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.books.update', $book) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label">
                                    عنوان الكتاب <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title', $book->title) }}" 
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="author" class="form-label">
                                    المؤلف <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('author') is-invalid @enderror" 
                                       id="author" 
                                       name="author" 
                                       value="{{ old('author', $book->author) }}" 
                                       required>
                                @error('author')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="category" class="form-label">التصنيف</label>
                                <select class="form-select @error('category') is-invalid @enderror" id="category" name="category">
                                    <option value="">اختر التصنيف</option>
                                    <option value="القرآن الكريم" {{ old('category', $book->category) == 'القرآن الكريم' ? 'selected' : '' }}>القرآن الكريم</option>
                                    <option value="الحديث الشريف" {{ old('category', $book->category) == 'الحديث الشريف' ? 'selected' : '' }}>الحديث الشريف</option>
                                    <option value="العقيدة" {{ old('category', $book->category) == 'العقيدة' ? 'selected' : '' }}>العقيدة</option>
                                    <option value="الفقه" {{ old('category', $book->category) == 'الفقه' ? 'selected' : '' }}>الفقه</option>
                                    <option value="السيرة النبوية" {{ old('category', $book->category) == 'السيرة النبوية' ? 'selected' : '' }}>السيرة النبوية</option>
                                    <option value="التاريخ الإسلامي" {{ old('category', $book->category) == 'التاريخ الإسلامي' ? 'selected' : '' }}>التاريخ الإسلامي</option>
                                    <option value="الأخلاق والآداب" {{ old('category', $book->category) == 'الأخلاق والآداب' ? 'selected' : '' }}>الأخلاق والآداب</option>
                                    <option value="أخرى" {{ old('category', $book->category) == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                                </select>
                                @error('category')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="description" class="form-label">
                                    وصف الكتاب <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('description') is-invalid @enderror" 
                                          id="description" 
                                          name="description" 
                                          rows="4" 
                                          required>{{ old('description', $book->description) }}</textarea>
                                @error('description')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="cover_image" class="form-label">غلاف الكتاب</label>
                                <input type="file" 
                                       class="form-control @error('cover_image') is-invalid @enderror" 
                                       id="cover_image" 
                                       name="cover_image" 
                                       accept="image/*">
                                @error('cover_image')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($book->cover_image)
                                    <small class="text-muted d-block mt-1">
                                        الغلاف الحالي: {{ basename($book->cover_image) }}
                                    </small>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="book_file" class="form-label">ملف الكتاب (PDF)</label>
                                <input type="file" 
                                       class="form-control @error('book_file') is-invalid @enderror" 
                                       id="book_file" 
                                       name="book_file" 
                                       accept=".pdf">
                                @error('book_file')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($book->file_path)
                                    <small class="text-muted d-block mt-1">
                                        الملف الحالي: {{ basename($book->file_path) }}
                                    </small>
                                @endif
                            </div>

                            @if($book->cover_image)
                            <div class="col-md-12 mb-3">
                                <label class="form-label">الغلاف الحالي</label>
                                <div class="text-center">
                                    <img src="{{ asset('storage/' . $book->cover_image) }}" 
                                         alt="{{ $book->title }}" 
                                         class="img-thumbnail" 
                                         style="max-height: 200px;">
                                </div>
                            </div>
                            @endif

                            <div class="col-md-6 mb-3">
                                <label for="publisher" class="form-label">الناشر</label>
                                <input type="text" 
                                       class="form-control @error('publisher') is-invalid @enderror" 
                                       id="publisher" 
                                       name="publisher" 
                                       value="{{ old('publisher', $book->publisher) }}">
                                @error('publisher')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="publication_year" class="form-label">سنة النشر</label>
                                <input type="number" 
                                       class="form-control @error('publication_year') is-invalid @enderror" 
                                       id="publication_year" 
                                       name="publication_year" 
                                       value="{{ old('publication_year', $book->publication_year) }}"
                                       min="1400" 
                                       max="{{ date('Y') }}">
                                @error('publication_year')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="isbn" class="form-label">رقم الكتاب الدولي (ISBN)</label>
                                <input type="text" 
                                       class="form-control @error('isbn') is-invalid @enderror" 
                                       id="isbn" 
                                       name="isbn" 
                                       value="{{ old('isbn', $book->isbn) }}">
                                @error('isbn')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="pages_count" class="form-label">عدد الصفحات</label>
                                <input type="number" 
                                       class="form-control @error('pages_count') is-invalid @enderror" 
                                       id="pages_count" 
                                       name="pages_count" 
                                       value="{{ old('pages_count', $book->pages_count) }}"
                                       min="1">
                                @error('pages_count')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="language" class="form-label">اللغة</label>
                                <select class="form-select @error('language') is-invalid @enderror" id="language" name="language">
                                    <option value="العربية" {{ old('language', $book->language) == 'العربية' ? 'selected' : '' }}>العربية</option>
                                    <option value="الإنجليزية" {{ old('language', $book->language) == 'الإنجليزية' ? 'selected' : '' }}>الإنجليزية</option>
                                    <option value="الفرنسية" {{ old('language', $book->language) == 'الفرنسية' ? 'selected' : '' }}>الفرنسية</option>
                                    <option value="أخرى" {{ old('language', $book->language) == 'أخرى' ? 'selected' : '' }}>أخرى</option>
                                </select>
                                @error('language')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="tags" class="form-label">العلامات</label>
                                <input type="text" 
                                       class="form-control @error('tags') is-invalid @enderror" 
                                       id="tags" 
                                       name="tags" 
                                       value="{{ old('tags', is_array($book->tags) ? implode(', ', $book->tags) : $book->tags) }}"
                                       placeholder="علامة1, علامة2, علامة3">
                                @error('tags')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">افصل بين العلامات بفاصلة</small>
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.books.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-right me-2"></i>
                                        العودة
                                    </a>
                                    <div>
                                        <a href="{{ route('admin.books.show', $book) }}" 
                                           class="btn btn-info me-2">
                                            <i class="fas fa-eye me-2"></i>
                                            عرض
                                        </a>
                                        @if($book->is_published)
                                            <button type="submit" name="action" value="draft" class="btn btn-outline-warning me-2">
                                                <i class="fas fa-archive me-2"></i>
                                                تحويل لمسودة
                                            </button>
                                        @else
                                            <button type="submit" name="action" value="publish" class="btn btn-success me-2">
                                                <i class="fas fa-paper-plane me-2"></i>
                                                نشر الكتاب
                                            </button>
                                        @endif
                                        <button type="submit" name="action" value="update" class="btn btn-primary">
                                            <i class="fas fa-save me-2"></i>
                                            حفظ التغييرات
                                        </button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>

        <div class="col-md-4">
            <!-- Book Statistics -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>
                        إحصائيات الكتاب
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-0">{{ number_format($book->download_count) }}</h4>
                                <small class="text-muted">التحميلات</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-0">{{ $book->rating ?: 'N/A' }}</h4>
                            <small class="text-muted">التقييم</small>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">تاريخ الإضافة:</small>
                        <small>{{ $book->created_at->format('Y/m/d') }}</small>
                    </div>
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">آخر تحديث:</small>
                        <small>{{ $book->updated_at->format('Y/m/d') }}</small>
                    </div>
                    @if($book->published_at)
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">تاريخ النشر:</small>
                        <small>{{ $book->published_at->format('Y/m/d') }}</small>
                    </div>
                    @endif
                </div>
            </div>

            <!-- Book Settings -->
            <div class="card shadow-sm">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        إعدادات الكتاب
                    </h6>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_featured" 
                               name="is_featured" 
                               value="1" 
                               {{ old('is_featured', $book->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            <i class="fas fa-star text-warning me-1"></i>
                            كتاب مميز
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="allow_download" 
                               name="allow_download" 
                               value="1" 
                               {{ old('allow_download', $book->allow_download) ? 'checked' : '' }}>
                        <label class="form-check-label" for="allow_download">
                            <i class="fas fa-download text-success me-1"></i>
                            السماح بالتحميل
                        </label>
                    </div>

                    <div class="form-check">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="allow_preview" 
                               name="allow_preview" 
                               value="1" 
                               {{ old('allow_preview', $book->allow_preview) ? 'checked' : '' }}>
                        <label class="form-check-label" for="allow_preview">
                            <i class="fas fa-eye text-info me-1"></i>
                            السماح بالمعاينة
                        </label>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
