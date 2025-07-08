@extends('layouts.courses')

@section('title', $course->title . ' - معهد أنوار العلماء')
@section('description', Str::limit($course->description, 160))

@section('content')
<!-- معلومات الدورة الأساسية -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 space-x-reverse text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-primary">الرئيسية</a></li>
                <li><i class="fas fa-chevron-left mx-2 text-gray-400"></i></li>
                <li><a href="{{ route('courses.index') }}" class="hover:text-primary">الدورات</a></li>
                <li><i class="fas fa-chevron-left mx-2 text-gray-400"></i></li>
                <li><a href="{{ route('categories.show', $course->category) }}" class="hover:text-primary">{{ $course->category->name }}</a></li>
                <li><i class="fas fa-chevron-left mx-2 text-gray-400"></i></li>
                <li class="text-gray-800 font-semibold">{{ $course->title }}</li>
            </ol>
        </nav>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- المحتوى الرئيسي -->
            <div class="lg:col-span-2">
                
                <!-- رأس الدورة -->
                <div class="mb-8">
                    <!-- صورة الدورة -->
                    <div class="h-64 md:h-80 bg-gradient-to-r from-blue-500 to-purple-600 rounded-lg overflow-hidden mb-6 relative">
                        @if($course->thumbnail)
                        <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" 
                             class="w-full h-full object-cover">
                        @endif
                        
                        <!-- تراكب معلومات -->
                        <div class="absolute bottom-0 left-0 right-0 bg-gradient-to-t from-black to-transparent p-6">
                            <div class="flex items-center space-x-4 space-x-reverse text-white">
                                @if($course->level)
                                <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm font-semibold">
                                    @if($course->level == 'beginner') مبتدئ
                                    @elseif($course->level == 'intermediate') متوسط  
                                    @else متقدم @endif
                                </span>
                                @endif
                                
                                <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm">
                                    <i class="fas fa-play-circle ml-1"></i>
                                    {{ $course->lessons->count() }} درس
                                </span>
                                
                                @if($course->duration)
                                <span class="bg-white bg-opacity-20 px-3 py-1 rounded-full text-sm">
                                    <i class="fas fa-clock ml-1"></i>
                                    {{ $course->formatted_duration }}
                                </span>
                                @endif
                            </div>
                        </div>
                    </div>

                    <!-- عنوان ووصف الدورة -->
                    <div class="mb-6">
                        <div class="flex items-center mb-4">
                            <span class="bg-primary text-white px-3 py-1 rounded-full text-sm font-semibold ml-4">
                                {{ $course->category->name }}
                            </span>
                            <span class="text-gray-500 text-sm">
                                تاريخ الإضافة: {{ $course->created_at->format('d/m/Y') }}
                            </span>
                        </div>
                        
                        <h1 class="text-3xl md:text-4xl font-bold text-gray-800 mb-4">
                            {{ $course->title }}
                        </h1>
                        
                        <p class="text-lg text-gray-600 leading-relaxed">
                            {{ $course->description }}
                        </p>
                    </div>

                    <!-- أزرار العمل الرئيسية -->
                    <div class="flex flex-wrap gap-4 mb-8">
                        @if($course->lessons->count() > 0)
                        <a href="{{ route('lessons.show', [$course, $course->lessons->first()]) }}" 
                           class="btn-primary">
                            <i class="fas fa-play ml-2"></i>
                            ابدأ الدورة
                        </a>
                        @endif
                        
                        <button onclick="shareContent()" class="btn-secondary">
                            <i class="fas fa-share-alt ml-2"></i>
                            مشاركة الدورة
                        </button>
                        
                        <button onclick="addToFavorites({{ $course->id }})" class="bg-gray-200 hover:bg-gray-300 text-gray-700 px-4 py-2 rounded-lg transition-colors duration-300">
                            <i class="fas fa-heart ml-2"></i>
                            إضافة للمفضلة
                        </button>
                    </div>
                </div>

                <!-- قائمة الدروس -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <h2 class="text-2xl font-bold text-gray-800">
                            <i class="fas fa-list-ol text-primary ml-2"></i>
                            دروس الدورة ({{ $course->lessons->count() }})
                        </h2>
                    </div>
                    
                    @if($course->lessons->count() > 0)
                    <div class="divide-y divide-gray-100">
                        @foreach($course->lessons as $index => $lesson)
                        <div class="p-6 hover:bg-gray-50 transition-colors duration-300">
                            <div class="flex items-start space-x-4 space-x-reverse">
                                
                                <!-- رقم الدرس -->
                                <div class="w-10 h-10 bg-primary text-white rounded-full flex items-center justify-center font-bold text-sm flex-shrink-0">
                                    {{ $index + 1 }}
                                </div>
                                
                                <!-- محتوى الدرس -->
                                <div class="flex-1 min-w-0">
                                    <div class="flex items-start justify-between">
                                        <div class="flex-1">
                                            <h3 class="text-lg font-semibold text-gray-800 mb-2">
                                                <a href="{{ route('lessons.show', [$course, $lesson]) }}" 
                                                   class="hover:text-primary transition-colors duration-300">
                                                    {{ $lesson->title }}
                                                </a>
                                            </h3>
                                            
                                            @if($lesson->description)
                                            <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                                                {{ Str::limit($lesson->description, 120) }}
                                            </p>
                                            @endif
                                            
                                            <!-- معلومات إضافية -->
                                            <div class="flex items-center space-x-4 space-x-reverse text-sm text-gray-500">
                                                @if($lesson->duration)
                                                <span>
                                                    <i class="fas fa-clock ml-1"></i>
                                                    {{ $lesson->formatted_duration }}
                                                </span>
                                                @endif
                                                
                                                @if($lesson->video_url)
                                                <span>
                                                    <i class="fas fa-video ml-1 text-red-500"></i>
                                                    فيديو
                                                </span>
                                                @endif
                                                
                                                @if($lesson->audio_url)
                                                <span>
                                                    <i class="fas fa-volume-up ml-1 text-green-500"></i>
                                                    صوت
                                                </span>
                                                @endif
                                                
                                                @if($lesson->additional_resources && count($lesson->additional_resources) > 0)
                                                <span>
                                                    <i class="fas fa-paperclip ml-1 text-blue-500"></i>
                                                    {{ count($lesson->additional_resources) }} مرفق
                                                </span>
                                                @endif
                                            </div>
                                        </div>
                                        
                                        <!-- زر التشغيل -->
                                        <a href="{{ route('lessons.show', [$course, $lesson]) }}" 
                                           class="btn-secondary whitespace-nowrap mr-4">
                                            <i class="fas fa-play ml-1"></i>
                                            مشاهدة
                                        </a>
                                    </div>
                                </div>
                            </div>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-video text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">لا توجد دروس بعد</h3>
                        <p class="text-gray-500">سيتم إضافة الدروس قريباً</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- الشريط الجانبي -->
            <div class="lg:col-span-1">
                
                <!-- معلومات العالم -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <h3 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-user-graduate text-primary ml-2"></i>
                            المحاضر
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        <div class="text-center mb-4">
                            <div class="w-20 h-20 bg-gray-300 rounded-full mx-auto mb-4 overflow-hidden">
                                @if($course->scholar->photo)
                                <img src="{{ $course->scholar->photo_url }}" alt="{{ $course->scholar->name }}" 
                                     class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full bg-primary flex items-center justify-center">
                                    <i class="fas fa-user text-white text-2xl"></i>
                                </div>
                                @endif
                            </div>
                            
                            <h4 class="text-xl font-bold text-gray-800 mb-2">
                                <a href="{{ route('scholars.show', $course->scholar) }}" 
                                   class="hover:text-primary transition-colors duration-300">
                                    {{ $course->scholar->name }}
                                </a>
                            </h4>
                            
                            @if($course->scholar->specialization)
                            <p class="text-gray-600 text-sm mb-4">{{ $course->scholar->specialization }}</p>
                            @endif
                        </div>
                        
                        @if($course->scholar->biography)
                        <p class="text-gray-600 text-sm mb-4 line-clamp-3">
                            {{ Str::limit($course->scholar->biography, 150) }}
                        </p>
                        @endif
                        
                        <a href="{{ route('scholars.show', $course->scholar) }}" 
                           class="w-full btn-secondary text-center block">
                            عرض الملف الشخصي
                        </a>
                    </div>
                </div>

                <!-- إحصائيات الدورة -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <h3 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-chart-bar text-primary ml-2"></i>
                            إحصائيات
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">عدد الدروس:</span>
                            <span class="font-bold text-primary">{{ $course->lessons->count() }}</span>
                        </div>
                        
                        @if($course->duration)
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">إجمالي المدة:</span>
                            <span class="font-bold text-primary">{{ $course->formatted_duration }}</span>
                        </div>
                        @endif
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">المستوى:</span>
                            <span class="font-bold text-primary">
                                @if($course->level == 'beginner') مبتدئ
                                @elseif($course->level == 'intermediate') متوسط  
                                @else متقدم @endif
                            </span>
                        </div>
                        
                        <div class="flex justify-between items-center">
                            <span class="text-gray-600">تاريخ الإضافة:</span>
                            <span class="font-bold text-primary">{{ $course->created_at->format('M Y') }}</span>
                        </div>
                    </div>
                </div>

                <!-- دورات مشابهة -->
                @if($relatedCourses->count() > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <h3 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-lightbulb text-primary ml-2"></i>
                            دورات من نفس القسم
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        @foreach($relatedCourses->take(3) as $relatedCourse)
                        <div class="border-b border-gray-100 pb-4 last:border-0">
                            <h4 class="font-semibold text-gray-800 mb-2">
                                <a href="{{ route('courses.show', $relatedCourse) }}" 
                                   class="hover:text-primary transition-colors duration-300 line-clamp-2">
                                    {{ $relatedCourse->title }}
                                </a>
                            </h4>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>{{ $relatedCourse->scholar->name }}</span>
                                <span>{{ $relatedCourse->lessons_count }} درس</span>
                            </div>
                        </div>
                        @endforeach
                        
                        <a href="{{ route('categories.show', $course->category) }}" 
                           class="text-primary hover:text-secondary text-sm font-semibold">
                            عرض المزيد من دورات {{ $course->category->name }}
                        </a>
                    </div>
                </div>
                @endif

                <!-- دورات للعالم نفسه -->
                @if($scholarCourses->count() > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <h3 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-graduation-cap text-primary ml-2"></i>
                            دورات أخرى للشيخ
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        @foreach($scholarCourses->take(3) as $scholarCourse)
                        <div class="border-b border-gray-100 pb-4 last:border-0">
                            <h4 class="font-semibold text-gray-800 mb-2">
                                <a href="{{ route('courses.show', $scholarCourse) }}" 
                                   class="hover:text-primary transition-colors duration-300 line-clamp-2">
                                    {{ $scholarCourse->title }}
                                </a>
                            </h4>
                            <div class="flex items-center justify-between text-sm text-gray-500">
                                <span>{{ $scholarCourse->category->name }}</span>
                                <span>{{ $scholarCourse->lessons_count }} درس</span>
                            </div>
                        </div>
                        @endforeach
                        
                        <a href="{{ route('scholars.show', $course->scholar) }}" 
                           class="text-primary hover:text-secondary text-sm font-semibold">
                            عرض جميع دورات الشيخ
                        </a>
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
function shareContent() {
    if (navigator.share) {
        navigator.share({
            title: '{{ $course->title }}',
            text: '{{ Str::limit($course->description, 100) }}',
            url: window.location.href
        }).catch(console.error);
    } else {
        // Fallback: copy to clipboard
        navigator.clipboard.writeText(window.location.href).then(() => {
            alert('تم نسخ رابط الدورة!');
        });
    }
}

function addToFavorites(courseId) {
    // TODO: Implement favorites functionality
    alert('سيتم إضافة هذه الميزة قريباً');
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

.line-clamp-3 {
    display: -webkit-box;
    -webkit-line-clamp: 3;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush
