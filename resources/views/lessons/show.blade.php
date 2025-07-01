@extends('layouts.courses')

@section('title', $lesson->title . ' - ' . $course->title . ' - معهد أنوار العلماء')
@section('description', Str::limit($lesson->description ?? $lesson->title, 160))

@section('content')
<!-- صفحة الدرس -->
<section class="py-8 bg-white">
    <div class="container mx-auto px-4">
        
        <!-- Breadcrumb -->
        <nav class="mb-6">
            <ol class="flex items-center space-x-2 space-x-reverse text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-primary">الرئيسية</a></li>
                <li><i class="fas fa-chevron-left mx-2 text-gray-400"></i></li>
                <li><a href="{{ route('courses.index') }}" class="hover:text-primary">الدورات</a></li>
                <li><i class="fas fa-chevron-left mx-2 text-gray-400"></i></li>
                <li><a href="{{ route('courses.show', $course) }}" class="hover:text-primary">{{ Str::limit($course->title, 30) }}</a></li>
                <li><i class="fas fa-chevron-left mx-2 text-gray-400"></i></li>
                <li class="text-gray-800 font-semibold">{{ Str::limit($lesson->title, 40) }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 xl:grid-cols-4 gap-8">
            
            <!-- المحتوى الرئيسي -->
            <div class="xl:col-span-3">
                
                <!-- معلومات الدرس -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    
                    <!-- رأس الدرس -->
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <div class="flex items-center justify-between">
                            <div class="flex items-center space-x-3 space-x-reverse">
                                <span class="bg-primary text-white px-3 py-1 rounded-full text-sm font-semibold">
                                    الدرس {{ $stats['current_lesson_number'] }} من {{ $stats['total_lessons'] }}
                                </span>
                                <span class="text-gray-600 text-sm">
                                    {{ $course->category->name }}
                                </span>
                            </div>
                            
                            <!-- شريط التقدم -->
                            <div class="flex items-center space-x-2 space-x-reverse">
                                <span class="text-sm text-gray-600">{{ $stats['completion_percentage'] }}%</span>
                                <div class="w-24 bg-gray-200 rounded-full h-2">
                                    <div class="progress-bar h-2 rounded-full" style="width: {{ $stats['completion_percentage'] }}%"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                    
                    <!-- محتوى الدرس -->
                    <div class="p-6">
                        <h1 class="text-2xl md:text-3xl font-bold text-gray-800 mb-4">
                            {{ $lesson->title }}
                        </h1>
                        
                        <div class="flex items-center space-x-4 space-x-reverse mb-6 text-sm text-gray-600">
                            <div class="flex items-center space-x-2 space-x-reverse">
                                <div class="w-8 h-8 bg-gray-300 rounded-full overflow-hidden">
                                    @if($course->scholar->photo)
                                    <img src="{{ $course->scholar->photo_url }}" alt="{{ $course->scholar->name }}" 
                                         class="w-full h-full object-cover">
                                    @else
                                    <div class="w-full h-full bg-primary flex items-center justify-center">
                                        <i class="fas fa-user text-white text-xs"></i>
                                    </div>
                                    @endif
                                </div>
                                <span class="font-semibold">{{ $course->scholar->name }}</span>
                            </div>
                            
                            @if($lesson->duration)
                            <span>
                                <i class="fas fa-clock ml-1"></i>
                                {{ $lesson->formatted_duration }}
                            </span>
                            @endif
                            
                            <span>
                                <i class="fas fa-calendar ml-1"></i>
                                {{ $lesson->created_at->format('d/m/Y') }}
                            </span>
                        </div>

                        <!-- مشغل الفيديو -->
                        @if($lesson->video_url)
                        <div class="video-container mb-6">
                            <iframe src="{{ $lesson->video_embed_url }}" 
                                    title="{{ $lesson->title }}"
                                    allowfullscreen>
                            </iframe>
                        </div>
                        @endif

                        <!-- مشغل الصوت -->
                        @if($lesson->audio_url && !$lesson->video_url)
                        <div class="bg-gray-50 rounded-lg p-6 mb-6">
                            <h3 class="text-lg font-semibold mb-4 flex items-center">
                                <i class="fas fa-volume-up text-primary ml-2"></i>
                                التسجيل الصوتي
                            </h3>
                            <audio controls class="w-full" preload="metadata">
                                <source src="{{ $lesson->audio_url }}" type="audio/mpeg">
                                المتصفح لا يدعم تشغيل الملفات الصوتية.
                            </audio>
                        </div>
                        @endif

                        <!-- وصف الدرس -->
                        @if($lesson->description)
                        <div class="prose max-w-none mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">وصف الدرس</h3>
                            <div class="text-gray-700 leading-relaxed">
                                {!! nl2br(e($lesson->description)) !!}
                            </div>
                        </div>
                        @endif

                        <!-- المحتوى النصي -->
                        @if($lesson->content)
                        <div class="prose max-w-none mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">محتوى الدرس</h3>
                            <div class="bg-gray-50 rounded-lg p-6 text-gray-700 leading-relaxed">
                                {!! nl2br(e($lesson->content)) !!}
                            </div>
                        </div>
                        @endif

                        <!-- الموارد الإضافية -->
                        @if($lesson->additional_resources && count($lesson->additional_resources) > 0)
                        <div class="mb-6">
                            <h3 class="text-xl font-bold text-gray-800 mb-4">
                                <i class="fas fa-paperclip text-primary ml-2"></i>
                                الموارد الإضافية
                            </h3>
                            <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                                @foreach($lesson->additional_resources as $index => $resource)
                                <div class="bg-gray-50 rounded-lg p-4 flex items-center justify-between">
                                    <div class="flex items-center space-x-3 space-x-reverse">
                                        <div class="w-10 h-10 bg-primary rounded-lg flex items-center justify-center">
                                            @if($resource['type'] == 'pdf')
                                            <i class="fas fa-file-pdf text-white"></i>
                                            @elseif($resource['type'] == 'link')
                                            <i class="fas fa-external-link-alt text-white"></i>
                                            @else
                                            <i class="fas fa-file text-white"></i>
                                            @endif
                                        </div>
                                        <div>
                                            <h4 class="font-semibold text-gray-800">{{ $resource['title'] ?? 'مورد إضافي' }}</h4>
                                            @if(isset($resource['description']))
                                            <p class="text-sm text-gray-600">{{ $resource['description'] }}</p>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    @if($resource['type'] == 'link')
                                    <a href="{{ $resource['url'] }}" target="_blank" 
                                       class="btn-secondary">
                                        <i class="fas fa-external-link-alt ml-1"></i>
                                        فتح
                                    </a>
                                    @else
                                    <a href="{{ route('lessons.download-resource', [$lesson, $index]) }}" 
                                       class="btn-secondary">
                                        <i class="fas fa-download ml-1"></i>
                                        تحميل
                                    </a>
                                    @endif
                                </div>
                                @endforeach
                            </div>
                        </div>
                        @endif
                    </div>
                </div>

                <!-- أزرار التنقل -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <div class="flex justify-between items-center">
                        
                        <!-- الدرس السابق -->
                        <div class="flex-1">
                            @if($previousLesson)
                            <a href="{{ route('lessons.show', [$course, $previousLesson]) }}" 
                               class="flex items-center space-x-3 space-x-reverse text-gray-600 hover:text-primary transition-colors duration-300 group">
                                <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary rounded-full flex items-center justify-center transition-colors duration-300">
                                    <i class="fas fa-arrow-right text-gray-600 group-hover:text-white"></i>
                                </div>
                                <div class="text-right">
                                    <div class="text-sm text-gray-500">الدرس السابق</div>
                                    <div class="font-semibold">{{ Str::limit($previousLesson->title, 40) }}</div>
                                </div>
                            </a>
                            @endif
                        </div>

                        <!-- العودة للدورة -->
                        <div class="mx-8">
                            <a href="{{ route('courses.show', $course) }}" 
                               class="btn-primary">
                                <i class="fas fa-list-ol ml-2"></i>
                                عرض محتوى الدورة
                            </a>
                        </div>

                        <!-- الدرس التالي -->
                        <div class="flex-1 text-left">
                            @if($nextLesson)
                            <a href="{{ route('lessons.show', [$course, $nextLesson]) }}" 
                               class="flex items-center space-x-3 space-x-reverse text-gray-600 hover:text-primary transition-colors duration-300 group">
                                <div class="text-left">
                                    <div class="text-sm text-gray-500">الدرس التالي</div>
                                    <div class="font-semibold">{{ Str::limit($nextLesson->title, 40) }}</div>
                                </div>
                                <div class="w-10 h-10 bg-gray-100 group-hover:bg-primary rounded-full flex items-center justify-center transition-colors duration-300">
                                    <i class="fas fa-arrow-left text-gray-600 group-hover:text-white"></i>
                                </div>
                            </a>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <!-- الشريط الجانبي -->
            <div class="xl:col-span-1">
                
                <!-- معلومات الدورة -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="bg-gray-50 px-4 py-3 border-b">
                        <h3 class="font-bold text-gray-800">
                            <i class="fas fa-book text-primary ml-2"></i>
                            معلومات الدورة
                        </h3>
                    </div>
                    
                    <div class="p-4">
                        <h4 class="font-semibold text-gray-800 mb-2">
                            <a href="{{ route('courses.show', $course) }}" 
                               class="hover:text-primary transition-colors duration-300">
                                {{ $course->title }}
                            </a>
                        </h4>
                        
                        <div class="space-y-2 text-sm text-gray-600">
                            <div class="flex justify-between">
                                <span>المحاضر:</span>
                                <span class="font-semibold">{{ $course->scholar->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>القسم:</span>
                                <span class="font-semibold">{{ $course->category->name }}</span>
                            </div>
                            <div class="flex justify-between">
                                <span>عدد الدروس:</span>
                                <span class="font-semibold">{{ $courseLessons->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- قائمة دروس الدورة -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-50 px-4 py-3 border-b">
                        <h3 class="font-bold text-gray-800">
                            <i class="fas fa-list-ol text-primary ml-2"></i>
                            دروس الدورة
                        </h3>
                    </div>
                    
                    <div class="max-h-96 overflow-y-auto">
                        @foreach($courseLessons as $index => $courseLesson)
                        <div class="border-b border-gray-100 last:border-0">
                            <a href="{{ route('lessons.show', [$course, $courseLesson]) }}" 
                               class="block p-4 hover:bg-gray-50 transition-colors duration-300 {{ $courseLesson->id == $lesson->id ? 'bg-blue-50 border-r-4 border-primary' : '' }}">
                                
                                <div class="flex items-start space-x-3 space-x-reverse">
                                    <!-- رقم الدرس -->
                                    <div class="w-6 h-6 {{ $courseLesson->id == $lesson->id ? 'bg-primary text-white' : 'bg-gray-200 text-gray-600' }} rounded-full flex items-center justify-center text-xs font-bold flex-shrink-0">
                                        {{ $index + 1 }}
                                    </div>
                                    
                                    <!-- تفاصيل الدرس -->
                                    <div class="flex-1 min-w-0">
                                        <h4 class="text-sm font-semibold {{ $courseLesson->id == $lesson->id ? 'text-primary' : 'text-gray-800' }} line-clamp-2">
                                            {{ $courseLesson->title }}
                                        </h4>
                                        
                                        <div class="flex items-center space-x-2 space-x-reverse mt-1 text-xs text-gray-500">
                                            @if($courseLesson->duration)
                                            <span>
                                                <i class="fas fa-clock ml-1"></i>
                                                {{ $courseLesson->formatted_duration }}
                                            </span>
                                            @endif
                                            
                                            @if($courseLesson->video_url)
                                            <span><i class="fas fa-video text-red-500"></i></span>
                                            @endif
                                            
                                            @if($courseLesson->audio_url)
                                            <span><i class="fas fa-volume-up text-green-500"></i></span>
                                            @endif
                                        </div>
                                    </div>
                                    
                                    <!-- أيقونة التشغيل للدرس الحالي -->
                                    @if($courseLesson->id == $lesson->id)
                                    <div class="text-primary">
                                        <i class="fas fa-play-circle"></i>
                                    </div>
                                    @endif
                                </div>
                            </a>
                        </div>
                        @endforeach
                    </div>
                </div>

                <!-- دروس مقترحة -->
                @if($suggestedLessons->count() > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden mt-6">
                    <div class="bg-gray-50 px-4 py-3 border-b">
                        <h3 class="font-bold text-gray-800">
                            <i class="fas fa-lightbulb text-primary ml-2"></i>
                            دروس مقترحة
                        </h3>
                    </div>
                    
                    <div class="p-4 space-y-3">
                        @foreach($suggestedLessons->take(3) as $suggestedLesson)
                        <div class="border-b border-gray-100 pb-3 last:border-0">
                            <h4 class="text-sm font-semibold text-gray-800 mb-1">
                                <a href="{{ route('lessons.show', [$suggestedLesson->course, $suggestedLesson]) }}" 
                                   class="hover:text-primary transition-colors duration-300 line-clamp-2">
                                    {{ $suggestedLesson->title }}
                                </a>
                            </h4>
                            <div class="text-xs text-gray-500">
                                {{ $suggestedLesson->course->title }} - {{ $suggestedLesson->course->scholar->name }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('scripts')
<script>
// تتبع تقدم المشاهدة (يمكن تطويره لاحقاً)
document.addEventListener('DOMContentLoaded', function() {
    const video = document.querySelector('iframe');
    if (video) {
        // يمكن إضافة تتبع تقدم المشاهدة هنا
        console.log('تم تحميل الفيديو');
    }
});

// تشغيل تلقائي للدرس التالي (اختياري)
function autoplayNext() {
    @if($nextLesson)
    if (confirm('هل تريد الانتقال للدرس التالي؟')) {
        window.location.href = '{{ route("lessons.show", [$course, $nextLesson]) }}';
    }
    @endif
}

// مشاركة الدرس
function shareLesson() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $lesson->title }}',
            text: 'درس من دورة {{ $course->title }}',
            url: window.location.href
        }).catch(console.error);
    } else {
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('تم نسخ رابط الدرس!');
        });
    }
}
</script>
@endpush

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}

/* تحسين مظهر شريط التمرير */
.overflow-y-auto::-webkit-scrollbar {
    width: 4px;
}

.overflow-y-auto::-webkit-scrollbar-track {
    background: #f1f1f1;
    border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb {
    background: #667eea;
    border-radius: 4px;
}

.overflow-y-auto::-webkit-scrollbar-thumb:hover {
    background: #5a67d8;
}
</style>
@endpush
