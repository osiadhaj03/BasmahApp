@extends('layouts.courses')

@section('title', $scholar->name . ' - معهد أنوار العلماء')
@section('description', Str::limit($scholar->biography ?? 'تعرف على ' . $scholar->name . ' وجميع دوراته وإنتاجه العلمي', 160))

@section('content')
<!-- صفحة العالم -->
<section class="py-12 bg-white">
    <div class="container mx-auto px-4">
        
        <!-- Breadcrumb -->
        <nav class="mb-8">
            <ol class="flex items-center space-x-2 space-x-reverse text-sm text-gray-600">
                <li><a href="{{ route('home') }}" class="hover:text-primary">الرئيسية</a></li>
                <li><i class="fas fa-chevron-left mx-2 text-gray-400"></i></li>
                <li><a href="{{ route('scholars.index') }}" class="hover:text-primary">العلماء</a></li>
                <li><i class="fas fa-chevron-left mx-2 text-gray-400"></i></li>
                <li class="text-gray-800 font-semibold">{{ $scholar->name }}</li>
            </ol>
        </nav>

        <!-- ملف العالم الشخصي -->
        <div class="bg-white rounded-lg shadow-md overflow-hidden mb-8">
            <div class="bg-primary text-white p-8">
                <div class="flex flex-col md:flex-row items-center md:items-start space-y-6 md:space-y-0 md:space-x-8 md:space-x-reverse">
                    
                    <!-- صورة العالم -->
                    <div class="w-32 h-32 bg-white bg-opacity-20 rounded-full overflow-hidden flex-shrink-0">
                        @if($scholar->photo)
                        <img src="{{ $scholar->photo_url }}" alt="{{ $scholar->name }}" 
                             class="w-full h-full object-cover">
                        @else
                        <div class="w-full h-full flex items-center justify-center">
                            <i class="fas fa-user-graduate text-6xl text-white opacity-70"></i>
                        </div>
                        @endif
                    </div>
                    
                    <!-- معلومات أساسية -->
                    <div class="flex-1 text-center md:text-right">
                        <h1 class="text-3xl md:text-4xl font-bold mb-4">
                            {{ $scholar->name }}
                        </h1>
                        
                        @if($scholar->specialization)
                        <p class="text-xl mb-4 opacity-90">
                            {{ $scholar->specialization }}
                        </p>
                        @endif
                        
                        <div class="flex flex-wrap justify-center md:justify-start gap-4 text-sm">
                            @if($scholar->birth_date)
                            <div class="bg-white bg-opacity-20 px-3 py-1 rounded-full">
                                <i class="fas fa-calendar-alt ml-1"></i>
                                ولد: {{ $scholar->birth_date->format('Y') }}
                            </div>
                            @endif
                            
                            @if($scholar->death_date)
                            <div class="bg-white bg-opacity-20 px-3 py-1 rounded-full">
                                <i class="fas fa-calendar-times ml-1"></i>
                                توفي: {{ $scholar->death_date->format('Y') }}
                            </div>
                            @else
                            <div class="bg-green-500 bg-opacity-70 px-3 py-1 rounded-full">
                                <i class="fas fa-heart ml-1"></i>
                                معاصر
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
            
            <!-- إحصائيات العالم -->
            <div class="bg-gray-50 p-6 border-b">
                <div class="grid grid-cols-2 md:grid-cols-4 gap-4 text-center">
                    <div>
                        <div class="text-2xl font-bold text-primary">{{ $stats['total_courses'] }}</div>
                        <div class="text-sm text-gray-600">دورة</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-primary">{{ $stats['total_lessons'] }}</div>
                        <div class="text-sm text-gray-600">درس</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-primary">{{ $stats['categories_count'] }}</div>
                        <div class="text-sm text-gray-600">قسم علمي</div>
                    </div>
                    <div>
                        <div class="text-2xl font-bold text-primary">
                            @if($stats['total_duration'] > 0)
                                {{ intval($stats['total_duration'] / 60) }}ساعة
                            @else
                                -
                            @endif
                        </div>
                        <div class="text-sm text-gray-600">مدة الدورات</div>
                    </div>
                </div>
            </div>
            
            <!-- السيرة الذاتية -->
            @if($scholar->biography)
            <div class="p-6">
                <h2 class="text-2xl font-bold text-gray-800 mb-4">
                    <i class="fas fa-user-circle text-primary ml-2"></i>
                    نبذة عن الشيخ
                </h2>
                <div class="text-gray-700 leading-relaxed">
                    {!! nl2br(e($scholar->biography)) !!}
                </div>
            </div>
            @endif
        </div>

        <div class="grid grid-cols-1 lg:grid-cols-3 gap-8">
            
            <!-- المحتوى الرئيسي -->
            <div class="lg:col-span-2">
                
                <!-- فلاتر وترتيب -->
                <div class="bg-white rounded-lg shadow-md p-6 mb-6">
                    <form method="GET" action="{{ route('scholars.show', $scholar) }}">
                        <div class="grid grid-cols-1 md:grid-cols-3 gap-4">
                            
                            <!-- تصفية حسب القسم -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">القسم</label>
                                <select name="category" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="">جميع الأقسام</option>
                                    @foreach($categories as $category)
                                    <option value="{{ $category->id }}" {{ request('category') == $category->id ? 'selected' : '' }}>
                                        {{ $category->name }}
                                    </option>
                                    @endforeach
                                </select>
                            </div>

                            <!-- تصفية حسب المستوى -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">المستوى</label>
                                <select name="level" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="">جميع المستويات</option>
                                    <option value="beginner" {{ request('level') == 'beginner' ? 'selected' : '' }}>مبتدئ</option>
                                    <option value="intermediate" {{ request('level') == 'intermediate' ? 'selected' : '' }}>متوسط</option>
                                    <option value="advanced" {{ request('level') == 'advanced' ? 'selected' : '' }}>متقدم</option>
                                </select>
                            </div>

                            <!-- الترتيب -->
                            <div>
                                <label class="block text-sm font-medium text-gray-700 mb-2">ترتيب حسب</label>
                                <select name="sort" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                                    <option value="created_at" {{ request('sort') == 'created_at' ? 'selected' : '' }}>الأحدث</option>
                                    <option value="title" {{ request('sort') == 'title' ? 'selected' : '' }}>الاسم</option>
                                    <option value="lessons_count" {{ request('sort') == 'lessons_count' ? 'selected' : '' }}>عدد الدروس</option>
                                </select>
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center mt-4">
                            <button type="submit" class="btn-primary">
                                <i class="fas fa-filter ml-2"></i>
                                تطبيق الفلاتر
                            </button>
                            
                            <a href="{{ route('scholars.show', $scholar) }}" class="text-gray-600 hover:text-primary transition-colors duration-300">
                                <i class="fas fa-times ml-1"></i>
                                مسح الفلاتر
                            </a>
                        </div>
                        
                        <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">
                    </form>
                </div>

                <!-- دورات العالم -->
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <div class="flex justify-between items-center">
                            <h2 class="text-2xl font-bold text-gray-800">
                                <i class="fas fa-book text-primary ml-2"></i>
                                دورات الشيخ ({{ $courses->total() }})
                            </h2>
                            
                            @if($courses->count() > 0)
                            <div class="text-sm text-gray-600">
                                عرض {{ $courses->firstItem() }} - {{ $courses->lastItem() }} من {{ $courses->total() }}
                            </div>
                            @endif
                        </div>
                    </div>
                    
                    @if($courses->count() > 0)
                    <div class="p-6">
                        <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                            @foreach($courses as $course)
                            <div class="bg-gray-50 rounded-lg overflow-hidden card-hover">
                                <!-- صورة الدورة -->
                                <div class="h-40 bg-gradient-to-r from-blue-500 to-purple-600 relative">
                                    @if($course->thumbnail)
                                    <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" 
                                         class="w-full h-full object-cover">
                                    @endif
                                    
                                    <div class="absolute top-3 right-3">
                                        @if($course->level == 'beginner')
                                        <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold">مبتدئ</span>
                                        @elseif($course->level == 'intermediate')
                                        <span class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold">متوسط</span>
                                        @else
                                        <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">متقدم</span>
                                        @endif
                                    </div>

                                    <div class="absolute bottom-3 left-3 bg-black bg-opacity-70 text-white px-2 py-1 rounded text-xs">
                                        <i class="fas fa-play-circle ml-1"></i>
                                        {{ $course->lessons_count }} درس
                                    </div>
                                </div>

                                <!-- محتوى البطاقة -->
                                <div class="p-4">
                                    <div class="flex items-center justify-between mb-2">
                                        <span class="text-xs text-primary font-semibold bg-blue-50 px-2 py-1 rounded">
                                            {{ $course->category->name }}
                                        </span>
                                        <span class="text-xs text-gray-500">
                                            {{ $course->created_at->format('M Y') }}
                                        </span>
                                    </div>

                                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">
                                        <a href="{{ route('courses.show', $course) }}" class="hover:text-primary transition-colors duration-300">
                                            {{ $course->title }}
                                        </a>
                                    </h3>

                                    <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                                        {{ Str::limit($course->description, 100) }}
                                    </p>

                                    <div class="flex space-x-2 space-x-reverse">
                                        <a href="{{ route('courses.show', $course) }}" class="flex-1 btn-secondary text-center">
                                            عرض الدورة
                                        </a>
                                        @if($course->lessons_count > 0)
                                        <a href="{{ route('lessons.show', [$course, $course->lessons->first()]) }}" 
                                           class="btn-primary text-center px-3">
                                            <i class="fas fa-play"></i>
                                        </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>

                        <!-- Pagination -->
                        @if($courses->hasPages())
                        <div class="mt-8 flex justify-center">
                            {{ $courses->appends(request()->query())->links() }}
                        </div>
                        @endif
                    </div>
                    @else
                    <div class="p-12 text-center">
                        <div class="w-16 h-16 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-4">
                            <i class="fas fa-book text-gray-400 text-2xl"></i>
                        </div>
                        <h3 class="text-lg font-semibold text-gray-700 mb-2">لا توجد دورات</h3>
                        <p class="text-gray-500">لم نجد دورات تطابق الفلاتر المحددة</p>
                    </div>
                    @endif
                </div>
            </div>

            <!-- الشريط الجانبي -->
            <div class="lg:col-span-1">
                
                <!-- أحدث الدروس -->
                @if($recentLessons->count() > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <h3 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-clock text-primary ml-2"></i>
                            أحدث الدروس
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        @foreach($recentLessons as $lesson)
                        <div class="border-b border-gray-100 pb-4 last:border-0">
                            <h4 class="font-semibold text-gray-800 mb-2">
                                <a href="{{ route('lessons.show', [$lesson->course, $lesson]) }}" 
                                   class="hover:text-primary transition-colors duration-300 line-clamp-2">
                                    {{ $lesson->title }}
                                </a>
                            </h4>
                            <div class="text-sm text-gray-500 mb-2">
                                من دورة: <a href="{{ route('courses.show', $lesson->course) }}" class="hover:text-primary">{{ $lesson->course->title }}</a>
                            </div>
                            <div class="text-xs text-gray-400">
                                {{ $lesson->created_at->diffForHumans() }}
                            </div>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- توزيع الدورات حسب الأقسام -->
                @if($coursesDistribution->count() > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden mb-6">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <h3 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-chart-pie text-primary ml-2"></i>
                            توزيع الدورات
                        </h3>
                    </div>
                    
                    <div class="p-6">
                        @foreach($coursesDistribution as $distribution)
                        <div class="flex items-center justify-between mb-3 last:mb-0">
                            <div class="flex items-center space-x-2 space-x-reverse">
                                <div class="w-3 h-3 rounded-full" style="background-color: {{ $distribution['color'] }}"></div>
                                <span class="text-sm text-gray-700">{{ $distribution['category'] }}</span>
                            </div>
                            <span class="text-sm font-semibold text-gray-800">{{ $distribution['count'] }}</span>
                        </div>
                        @endforeach
                    </div>
                </div>
                @endif

                <!-- علماء مشابهون -->
                @if($relatedScholars->count() > 0)
                <div class="bg-white rounded-lg shadow-md overflow-hidden">
                    <div class="bg-gray-50 px-6 py-4 border-b">
                        <h3 class="text-lg font-bold text-gray-800">
                            <i class="fas fa-users text-primary ml-2"></i>
                            علماء مشابهون
                        </h3>
                    </div>
                    
                    <div class="p-6 space-y-4">
                        @foreach($relatedScholars as $relatedScholar)
                        <div class="flex items-center space-x-3 space-x-reverse">
                            <div class="w-12 h-12 bg-gray-300 rounded-full overflow-hidden flex-shrink-0">
                                @if($relatedScholar->photo)
                                <img src="{{ $relatedScholar->photo_url }}" alt="{{ $relatedScholar->name }}" 
                                     class="w-full h-full object-cover">
                                @else
                                <div class="w-full h-full bg-primary flex items-center justify-center">
                                    <i class="fas fa-user text-white"></i>
                                </div>
                                @endif
                            </div>
                            
                            <div class="flex-1 min-w-0">
                                <h4 class="font-semibold text-gray-800">
                                    <a href="{{ route('scholars.show', $relatedScholar) }}" 
                                       class="hover:text-primary transition-colors duration-300">
                                        {{ $relatedScholar->name }}
                                    </a>
                                </h4>
                                <div class="text-sm text-gray-500">
                                    {{ $relatedScholar->courses_count }} دورة
                                </div>
                            </div>
                        </div>
                        @endforeach
                        
                        <a href="{{ route('scholars.index') }}" 
                           class="text-primary hover:text-secondary text-sm font-semibold block text-center mt-4">
                            عرض المزيد من العلماء
                        </a>
                    </div>
                </div>
                @endif
            </div>
        </div>
    </div>
</section>
@endsection

@push('styles')
<style>
.line-clamp-2 {
    display: -webkit-box;
    -webkit-line-clamp: 2;
    -webkit-box-orient: vertical;
    overflow: hidden;
}
</style>
@endpush
