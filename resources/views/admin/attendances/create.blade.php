@extends('layouts.admin')

@section('title', 'تسجيل حضور جديد')

@section('content')
<div class="d-flex justify-content-between align-items-center mb-4">
    <h1 class="h3 mb-0">تسجيل حضور جديد</h1>
    <a href="{{ route('admin.attendances.index') }}" class="btn btn-secondary">
        <i class="fas fa-arrow-left me-2"></i>
        العودة لسجلات الحضور
    </a>
</div>

<div class="card">
    <div class="card-body">
        <form method="POST" action="{{ route('admin.attendances.store') }}">
            @csrf
            
            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="lesson_id" class="form-label">الدرس <span class="text-danger">*</span></label>
                    <select class="form-control @error('lesson_id') is-invalid @enderror" 
                            id="lesson_id" 
                            name="lesson_id" 
                            required>
                        <option value="">اختر الدرس</option>
                        @foreach($lessons as $lesson)
                            <option value="{{ $lesson->id }}" @if(old('lesson_id') == $lesson->id) selected @endif>
                                {{ $lesson->subject }}
                                @if(auth()->user()->role === 'admin')
                                    - {{ $lesson->teacher->name }}
                                @endif
                            </option>
                        @endforeach
                    </select>
                    @error('lesson_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="student_id" class="form-label">الطالب <span class="text-danger">*</span></label>
                    <select class="form-control @error('student_id') is-invalid @enderror" 
                            id="student_id" 
                            name="student_id" 
                            required 
                            disabled>
                        <option value="">اختر الدرس أولاً</option>
                    </select>
                    @error('student_id')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="row">
                <div class="col-md-6 mb-3">
                    <label for="date" class="form-label">التاريخ <span class="text-danger">*</span></label>
                    <input type="date" 
                           class="form-control @error('date') is-invalid @enderror" 
                           id="date" 
                           name="date" 
                           value="{{ old('date', date('Y-m-d')) }}" 
                           required>
                    @error('date')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>

                <div class="col-md-6 mb-3">
                    <label for="status" class="form-label">حالة الحضور <span class="text-danger">*</span></label>
                    <select class="form-control @error('status') is-invalid @enderror" 
                            id="status" 
                            name="status" 
                            required>
                        <option value="">اختر الحالة</option>
                        <option value="present" @if(old('status') == 'present') selected @endif>حاضر</option>
                        <option value="absent" @if(old('status') == 'absent') selected @endif>غائب</option>
                        <option value="late" @if(old('status') == 'late') selected @endif>متأخر</option>
                        <option value="excused" @if(old('status') == 'excused') selected @endif>غياب بعذر</option>
                    </select>
                    @error('status')
                        <div class="invalid-feedback">{{ $message }}</div>
                    @enderror
                </div>
            </div>

            <div class="d-flex justify-content-between">
                <a href="{{ route('admin.attendances.index') }}" class="btn btn-secondary">
                    <i class="fas fa-times me-2"></i>
                    إلغاء
                </a>
                <button type="submit" class="btn btn-primary">
                    <i class="fas fa-save me-2"></i>
                    حفظ الحضور
                </button>
            </div>
        </form>
    </div>
</div>
@endsection

@push('scripts')
<script>
document.getElementById('lesson_id').addEventListener('change', function() {
    const lessonId = this.value;
    const studentSelect = document.getElementById('student_id');
    
    if (lessonId) {
        fetch(`/admin/lessons/${lessonId}/students`)
            .then(response => response.json())
            .then(data => {
                studentSelect.innerHTML = '<option value="">اختر الطالب</option>';
                data.students.forEach(student => {
                    studentSelect.innerHTML += `<option value="${student.id}">${student.name}</option>`;
                });
                studentSelect.disabled = false;
            })
            .catch(error => {
                console.error('Error:', error);
                studentSelect.innerHTML = '<option value="">خطأ في تحميل الطلاب</option>';
            });
    } else {
        studentSelect.innerHTML = '<option value="">اختر الدرس أولاً</option>';
        studentSelect.disabled = true;
    }
});
</script>
@endpush
