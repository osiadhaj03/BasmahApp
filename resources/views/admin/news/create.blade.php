@extends('layouts.admin')

@section('title', 'إضافة خبر جديد')

@section('content')
<div class="container-fluid">
    <div class="row mb-4">
        <div class="col-12">
            <h2 class="mb-0 text-primary">
                <i class="fas fa-plus-circle me-2"></i>
                إضافة خبر جديد
            </h2>
            <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{ route('admin.dashboard') }}">لوحة التحكم</a></li>
                    <li class="breadcrumb-item"><a href="{{ route('admin.news.index') }}">الأخبار</a></li>
                    <li class="breadcrumb-item active">إضافة خبر جديد</li>
                </ol>
            </nav>
        </div>
    </div>

    <div class="row">
        <div class="col-md-8">
            <div class="card shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">تفاصيل الخبر</h5>
                </div>
                <div class="card-body">
                    <form action="{{ route('admin.news.store') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        
                        <div class="row">
                            <div class="col-md-12 mb-3">
                                <label for="title" class="form-label">
                                    عنوان الخبر <span class="text-danger">*</span>
                                </label>
                                <input type="text" 
                                       class="form-control @error('title') is-invalid @enderror" 
                                       id="title" 
                                       name="title" 
                                       value="{{ old('title') }}" 
                                       required>
                                @error('title')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="type" class="form-label">نوع الخبر</label>
                                <select class="form-select @error('type') is-invalid @enderror" id="type" name="type">
                                    <option value="عام" {{ old('type') == 'عام' ? 'selected' : '' }}>عام</option>
                                    <option value="إعلان" {{ old('type') == 'إعلان' ? 'selected' : '' }}>إعلان</option>
                                    <option value="حدث" {{ old('type') == 'حدث' ? 'selected' : '' }}>حدث</option>
                                    <option value="تحديث" {{ old('type') == 'تحديث' ? 'selected' : '' }}>تحديث</option>
                                    <option value="عاجل" {{ old('type') == 'عاجل' ? 'selected' : '' }}>عاجل</option>
                                </select>
                                @error('type')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="priority" class="form-label">الأولوية</label>
                                <select class="form-select @error('priority') is-invalid @enderror" id="priority" name="priority">
                                    <option value="منخفضة" {{ old('priority') == 'منخفضة' ? 'selected' : '' }}>منخفضة</option>
                                    <option value="عادية" {{ old('priority', 'عادية') == 'عادية' ? 'selected' : '' }}>عادية</option>
                                    <option value="عالية" {{ old('priority') == 'عالية' ? 'selected' : '' }}>عالية</option>
                                    <option value="عاجلة" {{ old('priority') == 'عاجلة' ? 'selected' : '' }}>عاجلة</option>
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
                                          placeholder="ملخص قصير عن الخبر">{{ old('summary') }}</textarea>
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
                                          required>{{ old('content') }}</textarea>
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
                                <small class="text-muted">يمكنك اختيار أكثر من صورة</small>
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
                                <small class="text-muted">ملفات PDF، Word، أو أي مرفقات أخرى</small>
                            </div>

                            <div class="col-md-6 mb-3">
                                <label for="starts_at" class="form-label">تاريخ البداية</label>
                                <input type="datetime-local" 
                                       class="form-control @error('starts_at') is-invalid @enderror" 
                                       id="starts_at" 
                                       name="starts_at" 
                                       value="{{ old('starts_at') }}">
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
                                       value="{{ old('expires_at') }}">
                                @error('expires_at')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                                <small class="text-muted">اتركه فارغاً إذا كان الخبر لا ينتهي</small>
                            </div>

                            <div class="col-md-12 mb-3">
                                <label for="location" class="form-label">المكان</label>
                                <input type="text" 
                                       class="form-control @error('location') is-invalid @enderror" 
                                       id="location" 
                                       name="location" 
                                       value="{{ old('location') }}"
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
                                       value="{{ old('external_link') }}"
                                       placeholder="https://example.com">
                                @error('external_link')
                                    <div class="invalid-feedback">{{ $message }}</div>
                                @enderror
                            </div>
                        </div>

                        <div class="row mt-4">
                            <div class="col-12">
                                <div class="d-flex justify-content-between">
                                    <a href="{{ route('admin.news.index') }}" class="btn btn-secondary">
                                        <i class="fas fa-arrow-right me-2"></i>
                                        العودة
                                    </a>
                                    <div>
                                        <button type="submit" name="action" value="draft" class="btn btn-outline-primary me-2">
                                            <i class="fas fa-save me-2"></i>
                                            حفظ كمسودة
                                        </button>
                                        <button type="submit" name="action" value="publish" class="btn btn-success">
                                            <i class="fas fa-paper-plane me-2"></i>
                                            نشر الخبر
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
                               {{ old('is_featured') ? 'checked' : '' }}>
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
                               {{ old('is_urgent') ? 'checked' : '' }}>
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
                               {{ old('send_notification') ? 'checked' : '' }}>
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
                               {{ old('allow_comments', true) ? 'checked' : '' }}>
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
                               value="{{ old('tags') }}"
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
                <div class="card-header bg-info text-white">
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

    // Set default starts_at to now
    const startsAtInput = document.getElementById('starts_at');
    if (!startsAtInput.value) {
        const now = new Date();
        now.setMinutes(now.getMinutes() - now.getTimezoneOffset());
        startsAtInput.value = now.toISOString().slice(0, 16);
    }
});
</script>
@endsection
