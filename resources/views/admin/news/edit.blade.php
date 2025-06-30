@extends('layouts.admin')

@section('title', 'تعديل الخبر')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0 text-primary">
                <i class="fas fa-edit me-2"></i>
                تعديل الخبر: {{ $news->title }}
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.news.index') }}">الأخبار</a></li>
                    <li class="breadcrumb-item active">تعديل الخبر</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">تفاصيل الخبر</h5>
                    <div class="d-flex gap-2">
                        @if($news->is_published)
                            <span class="badge bg-success">منشور</span>
                        @else
                            <span class="badge bg-warning">مسودة</span>
                        @endif
                        @if($news->is_featured)
                            <span class="badge bg-warning">مميز</span>
                        @endif
                        @if($news->is_urgent)
                            <span class="badge bg-danger">عاجل</span>
                        @endif
                        <span class="badge bg-info">{{ $news->priority }}</span>
                    </div>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.news.update', $news) }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        @method('PUT')
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label">
                                    عنوان الخبر <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title', $news->title) }}" 
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">نوع الخبر</label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                                    <option value="عام" {{ old('type', $news->type) == 'عام' ? 'selected' : '' }}>عام</option>
                                    <option value="إعلان" {{ old('type', $news->type) == 'إعلان' ? 'selected' : '' }}>إعلان</option>
                                    <option value="حدث" {{ old('type', $news->type) == 'حدث' ? 'selected' : '' }}>حدث</option>
                                    <option value="تحديث" {{ old('type', $news->type) == 'تحديث' ? 'selected' : '' }}>تحديث</option>
                                    <option value="عاجل" {{ old('type', $news->type) == 'عاجل' ? 'selected' : '' }}>عاجل</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="priority" class="form-label">الأولوية</label>
                                <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority">
                                    <option value="منخفضة" {{ old('priority', $news->priority) == 'منخفضة' ? 'selected' : '' }}>منخفضة</option>
                                    <option value="عادية" {{ old('priority', $news->priority) == 'عادية' ? 'selected' : '' }}>عادية</option>
                                    <option value="عالية" {{ old('priority', $news->priority) == 'عالية' ? 'selected' : '' }}>عالية</option>
                                    <option value="عاجلة" {{ old('priority', $news->priority) == 'عاجلة' ? 'selected' : '' }}>عاجلة</option>
                                </select>
                                @error('priority')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="summary" class="form-label">
                                    ملخص الخبر <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('summary') is-invalid @enderror" 
                                          id="summary" 
                                          name="summary" 
                                          rows="3" 
                                          required 
                                          placeholder="ملخص قصير عن الخبر">{{ old('summary', $news->summary) }}</textarea>
                                @error('summary')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="content" class="form-label">
                                    محتوى الخبر <span class="text-danger">*</span>
                                </label>
                                <textarea class="form-control @error('content') is-invalid @enderror" 
                                          id="content" 
                                          name="content" 
                                          rows="10" 
                                          required>{{ old('content', $news->content) }}</textarea>
                                @error('content')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="images" class="form-label">صور الخبر</label>
                                <input type="file" 
                                       class="form-control @error('images') is-invalid @enderror" 
                                       id="images" 
                                       name="images[]" 
                                       multiple 
                                       accept="image/*">
                                @error('images')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($news->images && count($news->images) > 0)
                                    <small class="text-muted d-block mt-1">
                                        الصور الحالية: {{ count($news->images) }} صورة
                                    </small>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="attachments" class="form-label">مرفقات</label>
                                <input type="file" 
                                       class="form-control @error('attachments') is-invalid @enderror" 
                                       id="attachments" 
                                       name="attachments[]" 
                                       multiple>
                                @error('attachments')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($news->attachments && count($news->attachments) > 0)
                                    <small class="text-muted d-block mt-1">
                                        المرفقات الحالية: {{ count($news->attachments) }} ملف
                                    </small>
                                @endif
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="starts_at" class="form-label">تاريخ البداية</label>
                                <input type="datetime-local" 
                                       class="form-control @error('starts_at') is-invalid @enderror" 
                                       id="starts_at" 
                                       name="starts_at" 
                                       value="{{ old('starts_at', $news->starts_at ? $news->starts_at->format('Y-m-d\TH:i') : '') }}">
                                @error('starts_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="expires_at" class="form-label">تاريخ الانتهاء</label>
                                <input type="datetime-local" 
                                       class="form-control @error('expires_at') is-invalid @enderror" 
                                       id="expires_at" 
                                       name="expires_at" 
                                       value="{{ old('expires_at', $news->expires_at ? $news->expires_at->format('Y-m-d\TH:i') : '') }}">
                                @error('expires_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                @if($news->expires_at && $news->expires_at->isPast())
                                    <small class="text-danger">هذا الخبر قد انتهت صلاحيته</small>
                                @endif
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="location" class="form-label">المكان</label>
                                <input type="text" 
                                       class="form-control @error('location') is-invalid @enderror" 
                                       id="location" 
                                       name="location" 
                                       value="{{ old('location', $news->location) }}"
                                       placeholder="مكان الحدث أو المتعلق بالخبر">
                                @error('location')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="external_link" class="form-label">رابط خارجي</label>
                                <input type="url" 
                                       class="form-control @error('external_link') is-invalid @enderror" 
                                       id="external_link" 
                                       name="external_link" 
                                       value="{{ old('external_link', $news->external_link) }}"
                                       placeholder="https://example.com">
                                @error('external_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <!-- Current Images Display -->
                            @if($news->images && count($news->images) > 0)
                            <div class="col-md-12 mb-3">
                                <label class="form-label">الصور الحالية</label>
                                <div class="row">
                                    @foreach($news->images as $index => $image)
                                    <div class="col-md-3 mb-2">
                                        <div class="position-relative">
                                            <img src="{{ asset('storage/' . $image) }}" 
                                                 alt="صورة {{ $index + 1 }}" 
                                                 class="img-thumbnail w-100" 
                                                 style="height: 100px; object-fit: cover;">
                                            <div class="form-check position-absolute top-0 end-0 bg-white rounded p-1">
                                                <input class="form-check-input" 
                                                       type="checkbox" 
                                                       name="remove_images[]" 
                                                       value="{{ $image }}"
                                                       id="remove_image_{{ $index }}">
                                                <label class="form-check-label text-danger small" 
                                                       for="remove_image_{{ $index }}">
                                                    حذف
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif

                            <!-- Current Attachments Display -->
                            @if($news->attachments && count($news->attachments) > 0)
                            <div class="col-md-12 mb-3">
                                <label class="form-label">المرفقات الحالية</label>
                                <div class="list-group">
                                    @foreach($news->attachments as $index => $attachment)
                                    <div class="list-group-item d-flex justify-content-between align-items-center">
                                        <div>
                                            <i class="fas fa-file me-2"></i>
                                            {{ basename($attachment) }}
                                        </div>
                                        <div class="form-check">
                                            <input class="form-check-input" 
                                                   type="checkbox" 
                                                   name="remove_attachments[]" 
                                                   value="{{ $attachment }}"
                                                   id="remove_attachment_{{ $index }}">
                                            <label class="form-check-label text-danger" 
                                                   for="remove_attachment_{{ $index }}">
                                                حذف
                                            </label>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                            @endif
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-right me-2"></i>
                                        العودة
                                    </a>
                                    <div>
                                        @if($news->is_published)
                                            <button type="submit" name="action" value="draft" class="btn btn-outline-warning me-2">
                                                <i class="fas fa-archive me-2"></i>
                                                تحويل لمسودة
                                            </button>
                                        @else
                                            <button type="submit" name="action" value="publish" class="btn btn-success me-2">
                                                <i class="fas fa-paper-plane me-2"></i>
                                                نشر الخبر
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
            <!-- News Statistics -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-info text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-chart-line me-2"></i>
                        إحصائيات الخبر
                    </h6>
                </div>
                <div class="card-body">
                    <div class="row text-center">
                        <div class="col-6">
                            <div class="border-end">
                                <h4 class="text-primary mb-0">{{ number_format($news->views_count) }}</h4>
                                <small class="text-muted">المشاهدات</small>
                            </div>
                        </div>
                        <div class="col-6">
                            <h4 class="text-success mb-0">{{ $news->type }}</h4>
                            <small class="text-muted">نوع الخبر</small>
                        </div>
                    </div>
                    <hr>
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">تاريخ الإنشاء:</small>
                        <small>{{ $news->created_at->format('Y/m/d') }}</small>
                    </div>
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">آخر تحديث:</small>
                        <small>{{ $news->updated_at->format('Y/m/d') }}</small>
                    </div>
                    @if($news->published_at)
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">تاريخ النشر:</small>
                        <small>{{ $news->published_at->format('Y/m/d') }}</small>
                    </div>
                    @endif
                    @if($news->expires_at)
                    <div class="d-flex justify-content-between">
                        <small class="text-muted">تاريخ الانتهاء:</small>
                        <small class="{{ $news->expires_at->isPast() ? 'text-danger' : 'text-warning' }}">
                            {{ $news->expires_at->format('Y/m/d') }}
                        </small>
                    </div>
                    @endif
                </div>
            </div>

            <!-- News Settings -->
            <div class="card shadow-sm mb-4">
                <div class="card-header bg-warning text-dark">
                    <h6 class="mb-0">
                        <i class="fas fa-cogs me-2"></i>
                        إعدادات الخبر
                    </h6>
                </div>
                <div class="card-body">
                    <div class="form-check mb-3">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_featured" 
                               name="is_featured" 
                               value="1" 
                               {{ old('is_featured', $news->is_featured) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_featured">
                            <i class="fas fa-star text-warning me-1"></i>
                            خبر مميز
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="is_urgent" 
                               name="is_urgent" 
                               value="1" 
                               {{ old('is_urgent', $news->is_urgent) ? 'checked' : '' }}>
                        <label class="form-check-label" for="is_urgent">
                            <i class="fas fa-exclamation-triangle text-danger me-1"></i>
                            خبر عاجل
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="send_notification" 
                               name="send_notification" 
                               value="1" 
                               {{ old('send_notification', $news->send_notification) ? 'checked' : '' }}>
                        <label class="form-check-label" for="send_notification">
                            <i class="fas fa-bell text-info me-1"></i>
                            إرسال إشعار
                        </label>
                    </div>

                    <div class="form-check mb-3">
                        <input class="form-check-input" 
                               type="checkbox" 
                               id="allow_comments" 
                               name="allow_comments" 
                               value="1" 
                               {{ old('allow_comments', $news->allow_comments) ? 'checked' : '' }}>
                        <label class="form-check-label" for="allow_comments">
                            <i class="fas fa-comments text-primary me-1"></i>
                            السماح بالتعليقات
                        </label>
                    </div>

                    <div class="mb-3">
                        <label for="tags" class="form-label">العلامات</label>
                        <input type="text" 
                               class="form-control @error('tags') is-invalid @enderror" 
                               id="tags" 
                               name="tags" 
                               value="{{ old('tags', is_array($news->tags) ? implode(', ', $news->tags) : $news->tags) }}"
                               placeholder="علامة1, علامة2, علامة3">
                        @error('tags')
                            <div class="invalid-feedback">{{ $message }}</div>
                        @enderror
                        <small class="text-muted">افصل بين العلامات بفاصلة</small>
                    </div>
                </div>
            </div>

            <!-- Priority Guide -->
            <div class="card shadow-sm">
                <div class="card-header bg-secondary text-white">
                    <h6 class="mb-0">
                        <i class="fas fa-info-circle me-2"></i>
                        دليل الأولوية
                    </h6>
                </div>
                <div class="card-body">
                    <div class="small">
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-secondary me-2">منخفضة</span>
                            <span>أخبار عادية غير مهمة</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-primary me-2">عادية</span>
                            <span>أخبار اعتيادية</span>
                        </div>
                        <div class="d-flex align-items-center mb-2">
                            <span class="badge bg-warning me-2">عالية</span>
                            <span>أخبار مهمة</span>
                        </div>
                        <div class="d-flex align-items-center">
                            <span class="badge bg-danger me-2">عاجلة</span>
                            <span>أخبار عاجلة ومهمة جداً</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Auto-set priority based on type
    const typeSelect = document.getElementById('type');
    const prioritySelect = document.getElementById('priority');
    const isUrgentCheckbox = document.getElementById('is_urgent');
    
    typeSelect.addEventListener('change', function() {
        if (this.value === 'عاجل') {
            prioritySelect.value = 'عاجلة';
            isUrgentCheckbox.checked = true;
        }
    });

    // Auto-check urgent when priority is urgent
    prioritySelect.addEventListener('change', function() {
        if (this.value === 'عاجلة') {
            isUrgentCheckbox.checked = true;
        }
    });
});
</script>
@endsection
