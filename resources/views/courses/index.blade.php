@extends('layouts.courses')

@section('title', 'جميع الدورات الشرعية - معهد أنوار العلماء')
@section('description', 'استكشف مجموعتنا الشاملة من الدورات الشرعية في الفقه والحديث والتفسير وعلوم القرآن من أفضل العلماء')

@section('content')
<!-- Hero Section -->
<section class="bg-primary text-white py-20">
    <div class="container mx-auto px-4 text-center">
        <h1 class="text-4xl md:text-6xl font-bold mb-6">
            جميع الدورات الشرعية
        </h1>
        <p class="text-xl md:text-2xl mb-8 opacity-90 max-w-3xl mx-auto">
            استكشف مجموعتنا المتنوعة من الدورات الشرعية المتميزة في مختلف الفنون والعلوم الإسلامية
        </p>
        
        <!-- إحصائيات سريعة -->
        <div class="grid grid-cols-2 md:grid-cols-4 gap-4 max-w-4xl mx-auto">
            <div class="bg-white bg-opacity-20 rounded-lg p-4">
                <div class="text-3xl font-bold">{{ $stats['total_courses'] }}</div>
                <div class="text-sm opacity-90">دورة متاحة</div>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-4">
                <div class="text-3xl font-bold">{{ $stats['total_lessons'] }}</div>
                <div class="text-sm opacity-90">درس تعليمي</div>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-4">
                <div class="text-3xl font-bold">{{ $stats['total_categories'] }}</div>
                <div class="text-sm opacity-90">قسم علمي</div>
            </div>
            <div class="bg-white bg-opacity-20 rounded-lg p-4">
                <div class="text-3xl font-bold">{{ $stats['total_scholars'] }}</div>
                <div class="text-sm opacity-90">عالم متخصص</div>
            </div>
        </div>
    </div>
</section>

<!-- أقسام الدورات -->
@if($categories->count() > 0)
<section class="py-16 bg-white">
    <div class="container mx-auto px-4">
        <h2 class="text-3xl font-bold text-center mb-12 text-gray-800">
            <i class="fas fa-tags text-primary ml-2"></i>
            الأقسام العلمية
        </h2>
        
        <div class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-6 gap-4 mb-12">
            <!-- جميع الأقسام -->
            <a href="{{ route('courses.index') }}" 
               class="group bg-gray-100 hover:bg-primary transition-all duration-300 rounded-lg p-4 text-center {{ !request('category') ? 'bg-primary text-white' : '' }}">
                <i class="fas fa-th-large text-2xl mb-2 {{ !request('category') ? 'text-white' : 'text-primary group-hover:text-white' }}"></i>
                <div class="text-sm font-semibold {{ !request('category') ? 'text-white' : 'text-gray-700 group-hover:text-white' }}">جميع الأقسام</div>
            </a>
            
            @foreach($categories as $category)
            <a href="{{ route('courses.index', ['category' => $category->id]) }}" 
               class="group bg-gray-100 hover:bg-primary transition-all duration-300 rounded-lg p-4 text-center {{ request('category') == $category->id ? 'bg-primary text-white' : '' }}">
                <i class="fas fa-book text-2xl mb-2 {{ request('category') == $category->id ? 'text-white' : 'text-primary group-hover:text-white' }}"></i>
                <div class="text-sm font-semibold {{ request('category') == $category->id ? 'text-white' : 'text-gray-700 group-hover:text-white' }}">{{ $category->name }}</div>
                <div class="text-xs {{ request('category') == $category->id ? 'text-white opacity-90' : 'text-gray-500 group-hover:text-white' }}">{{ $category->courses_count }} دورة</div>
            </a>
            @endforeach
        </div>
    </div>
</section>
@endif

<!-- فلاتر البحث والترتيب -->
<section class="py-8 bg-gray-50">
    <div class="container mx-auto px-4">
        <form method="GET" action="{{ route('courses.index') }}" class="bg-white rounded-lg shadow-md p-6">
            <div class="grid grid-cols-1 md:grid-cols-5 gap-4">
                
                <!-- البحث -->
                <div class="md:col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-2">البحث في الدورات</label>
                    <div class="relative">
                        <input type="text" name="search" value="{{ request('search') }}" 
                               placeholder="ابحث بالعنوان أو الوصف..."
                               class="w-full px-4 py-2 pr-10 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <i class="fas fa-search absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400"></i>
                    </div>
                </div>

                <!-- تصفية حسب العالم -->
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-2">العالم</label>
                    <select name="scholar" class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-primary focus:border-transparent">
                        <option value="">جميع العلماء</option>
                        @foreach($scholars as $scholar)
                        <option value="{{ $scholar->id }}" {{ request('scholar') == $scholar->id ? 'selected' : '' }}>
                            {{ $scholar->name }}
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
                        <option value="duration" {{ request('sort') == 'duration' ? 'selected' : '' }}>المدة</option>
                    </select>
                </div>
            </div>

            <!-- أزرار العمل -->
            <div class="flex justify-between items-center mt-6">
                <button type="submit" class="btn-primary">
                    <i class="fas fa-search ml-2"></i>
                    بحث وتصفية
                </button>
                
                <a href="{{ route('courses.index') }}" class="text-gray-600 hover:text-primary transition-colors duration-300">
                    <i class="fas fa-times ml-1"></i>
                    مسح الفلاتر
                </a>
            </div>

            <!-- حفظ القيم المخفية -->
            <input type="hidden" name="category" value="{{ request('category') }}">
            <input type="hidden" name="direction" value="{{ request('direction', 'desc') }}">
        </form>
    </div>
</section>

<!-- قائمة الدورات -->
<section class="py-12">
    <div class="container mx-auto px-4">
        
        <!-- معلومات النتائج -->
        <div class="flex justify-between items-center mb-8">
            <div class="text-gray-600">
                عرض {{ $courses->firstItem() ?? 0 }} - {{ $courses->lastItem() ?? 0 }} من أصل {{ $courses->total() }} دورة
            </div>
            
            <div class="flex items-center space-x-4 space-x-reverse">
                <span class="text-sm text-gray-600">عرض:</span>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'created_at', 'direction' => 'desc']) }}" 
                   class="text-sm {{ request('sort') == 'created_at' ? 'text-primary font-semibold' : 'text-gray-600 hover:text-primary' }}">
                    الأحدث
                </a>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'title', 'direction' => 'asc']) }}" 
                   class="text-sm {{ request('sort') == 'title' ? 'text-primary font-semibold' : 'text-gray-600 hover:text-primary' }}">
                    أبجدياً
                </a>
                <a href="{{ request()->fullUrlWithQuery(['sort' => 'lessons_count', 'direction' => 'desc']) }}" 
                   class="text-sm {{ request('sort') == 'lessons_count' ? 'text-primary font-semibold' : 'text-gray-600 hover:text-primary' }}">
                    الأكثر دروساً
                </a>
            </div>
        </div>

        @if($courses->count() > 0)
        <!-- شبكة الدورات -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6">
            @foreach($courses as $course)
            <div class="bg-white rounded-lg shadow-md overflow-hidden card-hover">
                <!-- صورة الدورة -->
                <div class="h-48 bg-gradient-to-r from-blue-500 to-purple-600 relative">
                    @if($course->thumbnail)
                    <img src="{{ $course->thumbnail_url }}" alt="{{ $course->title }}" 
                         class="w-full h-full object-cover">
                    @endif
                    
                    <!-- شارة المستوى -->
                    <div class="absolute top-3 right-3">
                        @if($course->level == 'beginner')
                        <span class="bg-green-500 text-white px-2 py-1 rounded-full text-xs font-semibold">مبتدئ</span>
                        @elseif($course->level == 'intermediate')
                        <span class="bg-yellow-500 text-white px-2 py-1 rounded-full text-xs font-semibold">متوسط</span>
                        @else
                        <span class="bg-red-500 text-white px-2 py-1 rounded-full text-xs font-semibold">متقدم</span>
                        @endif
                    </div>

                    <!-- شارة عدد الدروس -->
                    <div class="absolute bottom-3 left-3 bg-black bg-opacity-70 text-white px-2 py-1 rounded text-xs">
                        <i class="fas fa-play-circle ml-1"></i>
                        {{ $course->lessons_count }} درس
                    </div>
                </div>

                <!-- محتوى البطاقة -->
                <div class="p-4">
                    <!-- القسم -->
                    <div class="flex items-center justify-between mb-2">
                        <span class="text-xs text-primary font-semibold bg-blue-50 px-2 py-1 rounded">
                            {{ $course->category->name }}
                        </span>
                        @if($course->duration)
                        <span class="text-xs text-gray-500">
                            <i class="fas fa-clock ml-1"></i>
                            {{ $course->formatted_duration }}
                        </span>
                        @endif
                    </div>

                    <!-- عنوان الدورة -->
                    <h3 class="text-lg font-bold text-gray-800 mb-2 line-clamp-2">
                        <a href="{{ route('courses.show', $course) }}" class="hover:text-primary transition-colors duration-300">
                            {{ $course->title }}
                        </a>
                    </h3>

                    <!-- وصف مختصر -->
                    <p class="text-gray-600 text-sm mb-3 line-clamp-2">
                        {{ Str::limit($course->description, 100) }}
                    </p>

                    <!-- معلومات العالم -->
                    <div class="flex items-center justify-between mb-4">
                        <div class="flex items-center space-x-2 space-x-reverse">
                            <div class="w-8 h-8 bg-gray-300 rounded-full flex items-center justify-center">
                                @if($course->scholar->photo)
                                <img src="{{ $course->scholar->photo_url }}" alt="{{ $course->scholar->name }}" 
                                     class="w-full h-full rounded-full object-cover">
                                @else
                                <i class="fas fa-user text-gray-600 text-xs"></i>
                                @endif
                            </div>
                            <div>
                                <div class="text-sm font-semibold text-gray-800">{{ $course->scholar->name }}</div>
                                <div class="text-xs text-gray-500">{{ $course->scholar->specialization }}</div>
                            </div>
                        </div>
                    </div>

                    <!-- أزرار العمل -->
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
        <div class="mt-12 flex justify-center">
            {{ $courses->appends(request()->query())->links() }}
        </div>

        @else
        <!-- رسالة عدم وجود نتائج -->
        <div class="text-center py-16">
            <div class="w-24 h-24 bg-gray-200 rounded-full flex items-center justify-center mx-auto mb-6">
                <i class="fas fa-search text-gray-400 text-3xl"></i>
            </div>
            <h3 class="text-2xl font-bold text-gray-700 mb-4">لا توجد دورات</h3>
            <p class="text-gray-600 mb-6">لم نجد أي دورات تطابق معايير البحث المحددة</p>
            <a href="{{ route('courses.index') }}" class="btn-primary">
                <i class="fas fa-arrow-right ml-2"></i>
                عرض جميع الدورات
            </a>
        </div>
        @endif
    </div>
</section>

<!-- دعوة للعمل -->
<section class="py-16 bg-gray-900 text-white">
    <div class="container mx-auto px-4 text-center">
        <h2 class="text-3xl font-bold mb-4">هل تبحث عن دورة معينة؟</h2>
        <p class="text-xl mb-8 opacity-90">استخدم البحث المتقدم للعثور على الدورة المناسبة لك</p>
        <a href="{{ route('advanced-search') }}" class="btn-primary">
            <i class="fas fa-search-plus ml-2"></i>
            البحث المتقدم
        </a>
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
