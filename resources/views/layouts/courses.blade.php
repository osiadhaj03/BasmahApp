<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'معهد أنوار العلماء - الدورات الشرعية')</title>
    <meta name="description" content="@yield('description', 'معهد أنوار العلماء للدورات الشرعية - تعلم العلوم الإسلامية من أفضل العلماء')">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    
    <!-- Custom Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    
    <!-- Custom Styles -->
    <style>
        body {
            font-family: 'Cairo', sans-serif;
            direction: rtl;
            text-align: right;
        }

        /* تدرجات الألوان الأساسية */
        .bg-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }
        
        .bg-secondary {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
        }

        .text-primary {
            color: #667eea;
        }

        .text-secondary {
            color: #0984e3;
        }

        /* تأثيرات الحركة */
        .card-hover {
            transition: all 0.3s ease;
        }
        
        .card-hover:hover {
            transform: translateY(-5px);
            box-shadow: 0 20px 25px -5px rgba(0, 0, 0, 0.1), 0 10px 10px -5px rgba(0, 0, 0, 0.04);
        }

        /* أزرار مخصصة */
        .btn-primary {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 0.75rem 2rem;
            border-radius: 9999px;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-primary:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .btn-secondary {
            background: linear-gradient(135deg, #74b9ff 0%, #0984e3 100%);
            color: white;
            padding: 0.5rem 1.5rem;
            border-radius: 0.5rem;
            font-weight: 600;
            transition: all 0.3s ease;
            border: none;
            cursor: pointer;
        }
        
        .btn-secondary:hover {
            transform: translateY(-1px);
            box-shadow: 0 5px 10px -2px rgba(0, 0, 0, 0.1);
        }

        /* خلفية الصفحة */
        .page-background {
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100"><defs><pattern id="grain" width="100" height="100" patternUnits="userSpaceOnUse"><circle cx="50" cy="50" r="1" fill="%23f8fafc" opacity="0.1"/></pattern></defs><rect width="100" height="100" fill="url(%23grain)"/></svg>');
        }

        /* تحسين الفيديو المدمج */
        .video-container {
            position: relative;
            width: 100%;
            padding-bottom: 56.25%; /* نسبة 16:9 */
            height: 0;
            overflow: hidden;
            border-radius: 0.75rem;
            box-shadow: 0 10px 15px rgba(0, 0, 0, 0.1);
        }
        
        .video-container iframe {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            border: none;
        }

        /* شريط التقدم */
        .progress-bar {
            background: linear-gradient(90deg, #667eea 0%, #764ba2 100%);
            height: 4px;
            border-radius: 2px;
            transition: width 0.3s ease;
        }

        /* تحسين القائمة المنسدلة */
        .dropdown:hover .dropdown-menu {
            display: block;
        }

        /* شعار متحرك */
        .floating {
            animation: floating 3s ease-in-out infinite;
        }

        @keyframes floating {
            0%, 100% { transform: translateY(0px); }
            50% { transform: translateY(-10px); }
        }

        /* تأثيرات التحميل */
        .loading {
            opacity: 0.7;
            pointer-events: none;
        }

        .spinner {
            border: 2px solid #f3f3f3;
            border-radius: 50%;
            border-top: 2px solid #667eea;
            width: 20px;
            height: 20px;
            animation: spin 1s linear infinite;
        }

        @keyframes spin {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }
    </style>

    @stack('styles')
</head>
<body class="bg-gray-50 page-background">
    
    <!-- Header -->
    <header class="bg-white shadow-md sticky top-0 z-50">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center py-4">
                
                <!-- الشعار -->
                <div class="flex items-center space-x-3 space-x-reverse">
                    <a href="{{ route('home') }}" class="flex items-center space-x-2 space-x-reverse">
                        <div class="w-12 h-12 bg-primary rounded-full flex items-center justify-center floating">
                            <i class="fas fa-graduation-cap text-white text-xl"></i>
                        </div>
                        <div>
                            <h1 class="text-xl font-bold text-gray-800">معهد أنوار العلماء</h1>
                            <p class="text-sm text-gray-600">للدورات الشرعية</p>
                        </div>
                    </a>
                </div>

                <!-- التنقل الأساسي -->
                <nav class="hidden md:flex items-center space-x-6 space-x-reverse">
                    <a href="{{ route('home') }}" class="text-gray-700 hover:text-primary transition-colors duration-300 {{ request()->routeIs('home') ? 'text-primary font-semibold' : '' }}">
                        <i class="fas fa-home ml-1"></i>
                        الرئيسية
                    </a>
                    <a href="{{ route('courses.index') }}" class="text-gray-700 hover:text-primary transition-colors duration-300 {{ request()->routeIs('courses.*') ? 'text-primary font-semibold' : '' }}">
                        <i class="fas fa-book ml-1"></i>
                        الدورات
                    </a>
                    <a href="{{ route('scholars.index') }}" class="text-gray-700 hover:text-primary transition-colors duration-300 {{ request()->routeIs('scholars.*') ? 'text-primary font-semibold' : '' }}">
                        <i class="fas fa-user-graduate ml-1"></i>
                        العلماء
                    </a>
                    <a href="{{ route('categories.index') }}" class="text-gray-700 hover:text-primary transition-colors duration-300 {{ request()->routeIs('categories.*') ? 'text-primary font-semibold' : '' }}">
                        <i class="fas fa-tags ml-1"></i>
                        الأقسام
                    </a>
                    <a href="{{ route('about') }}" class="text-gray-700 hover:text-primary transition-colors duration-300 {{ request()->routeIs('about') ? 'text-primary font-semibold' : '' }}">
                        <i class="fas fa-info-circle ml-1"></i>
                        حول الموقع
                    </a>
                </nav>

                <!-- البحث وأيقونات -->
                <div class="flex items-center space-x-4 space-x-reverse">
                    
                    <!-- نموذج البحث -->
                    <form action="{{ route('search') }}" method="GET" class="hidden md:flex">
                        <div class="relative">
                            <input type="text" name="q" placeholder="ابحث في الدورات والدروس..." 
                                   value="{{ request('q') }}"
                                   class="w-64 px-4 py-2 pr-10 bg-gray-100 border-0 rounded-full focus:ring-2 focus:ring-primary focus:bg-white transition-all duration-300">
                            <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400 hover:text-primary">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <!-- البحث المتقدم -->
                    <a href="{{ route('advanced-search') }}" class="text-gray-600 hover:text-primary transition-colors duration-300" title="البحث المتقدم">
                        <i class="fas fa-search-plus"></i>
                    </a>

                    <!-- قائمة الهاتف -->
                    <button id="mobile-menu-btn" class="md:hidden text-gray-600 hover:text-primary transition-colors duration-300">
                        <i class="fas fa-bars text-xl"></i>
                    </button>
                </div>
            </div>

            <!-- القائمة المخفية للهاتف -->
            <div id="mobile-menu" class="md:hidden hidden pb-4 border-t border-gray-200">
                <div class="space-y-2 pt-4">
                    <!-- البحث في الهاتف -->
                    <form action="{{ route('search') }}" method="GET" class="mb-4">
                        <div class="relative">
                            <input type="text" name="q" placeholder="ابحث..." 
                                   value="{{ request('q') }}"
                                   class="w-full px-4 py-2 pr-10 bg-gray-100 border-0 rounded-lg focus:ring-2 focus:ring-primary">
                            <button type="submit" class="absolute right-3 top-1/2 transform -translate-y-1/2 text-gray-400">
                                <i class="fas fa-search"></i>
                            </button>
                        </div>
                    </form>

                    <a href="{{ route('home') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-home ml-2"></i>الرئيسية
                    </a>
                    <a href="{{ route('courses.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-book ml-2"></i>الدورات
                    </a>
                    <a href="{{ route('scholars.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-user-graduate ml-2"></i>العلماء
                    </a>
                    <a href="{{ route('categories.index') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-tags ml-2"></i>الأقسام
                    </a>
                    <a href="{{ route('about') }}" class="block px-4 py-2 text-gray-700 hover:bg-gray-100 rounded-lg">
                        <i class="fas fa-info-circle ml-2"></i>حول الموقع
                    </a>
                </div>
            </div>
        </div>
    </header>

    <!-- المحتوى الرئيسي -->
    <main>
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="bg-gray-900 text-white mt-20">
        <div class="container mx-auto px-4 py-12">
            
            <!-- الجزء الأساسي -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-8 mb-8">
                
                <!-- معلومات الموقع -->
                <div class="md:col-span-2">
                    <div class="flex items-center space-x-3 space-x-reverse mb-4">
                        <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center">
                            <i class="fas fa-graduation-cap text-white"></i>
                        </div>
                        <div>
                            <h3 class="text-lg font-bold">معهد أنوار العلماء</h3>
                            <p class="text-gray-400 text-sm">للدورات الشرعية</p>
                        </div>
                    </div>
                    <p class="text-gray-300 mb-4 leading-relaxed">
                        منصة رائدة في تقديم الدورات الشرعية المتميزة من أفضل العلماء والمختصين، 
                        نهدف إلى نشر العلم النافع وتيسير طلب العلم الشرعي للجميع.
                    </p>
                    <div class="flex space-x-4 space-x-reverse">
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">
                            <i class="fab fa-youtube text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">
                            <i class="fab fa-facebook text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">
                            <i class="fab fa-twitter text-xl"></i>
                        </a>
                        <a href="#" class="text-gray-400 hover:text-primary transition-colors duration-300">
                            <i class="fab fa-instagram text-xl"></i>
                        </a>
                    </div>
                </div>

                <!-- روابط سريعة -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">روابط سريعة</h4>
                    <ul class="space-y-2">
                        <li><a href="{{ route('courses.index') }}" class="text-gray-300 hover:text-primary transition-colors duration-300">جميع الدورات</a></li>
                        <li><a href="{{ route('scholars.index') }}" class="text-gray-300 hover:text-primary transition-colors duration-300">العلماء</a></li>
                        <li><a href="{{ route('categories.index') }}" class="text-gray-300 hover:text-primary transition-colors duration-300">الأقسام</a></li>
                        <li><a href="{{ route('search') }}" class="text-gray-300 hover:text-primary transition-colors duration-300">البحث</a></li>
                        <li><a href="{{ route('about') }}" class="text-gray-300 hover:text-primary transition-colors duration-300">حول الموقع</a></li>
                    </ul>
                </div>

                <!-- معلومات التواصل -->
                <div>
                    <h4 class="text-lg font-semibold mb-4">تواصل معنا</h4>
                    <ul class="space-y-2">
                        <li class="flex items-center space-x-2 space-x-reverse text-gray-300">
                            <i class="fas fa-envelope text-primary"></i>
                            <span>info@anwar-scholars.com</span>
                        </li>
                        <li class="flex items-center space-x-2 space-x-reverse text-gray-300">
                            <i class="fas fa-phone text-primary"></i>
                            <span>+970 123 456 789</span>
                        </li>
                        <li class="flex items-center space-x-2 space-x-reverse text-gray-300">
                            <i class="fas fa-map-marker-alt text-primary"></i>
                            <span>غزة، فلسطين</span>
                        </li>
                    </ul>
                </div>
            </div>

            <!-- الخط الفاصل -->
            <div class="border-t border-gray-700 pt-8">
                <div class="flex flex-col md:flex-row justify-between items-center">
                    <p class="text-gray-400 text-sm">
                        © {{ date('Y') }} معهد أنوار العلماء. جميع الحقوق محفوظة.
                    </p>
                    <div class="flex space-x-4 space-x-reverse mt-4 md:mt-0">
                        <a href="#" class="text-gray-400 hover:text-primary text-sm transition-colors duration-300">سياسة الخصوصية</a>
                        <a href="#" class="text-gray-400 hover:text-primary text-sm transition-colors duration-300">شروط الاستخدام</a>
                        <a href="#" class="text-gray-400 hover:text-primary text-sm transition-colors duration-300">اتفاقية الاستخدام</a>
                    </div>
                </div>
            </div>
        </div>
    </footer>

    <!-- JavaScript -->
    <script>
        // قائمة الهاتف
        document.getElementById('mobile-menu-btn').addEventListener('click', function() {
            const menu = document.getElementById('mobile-menu');
            menu.classList.toggle('hidden');
        });

        // تأثير loading للنماذج
        document.querySelectorAll('form').forEach(form => {
            form.addEventListener('submit', function() {
                const submitButton = form.querySelector('button[type="submit"]');
                if (submitButton) {
                    submitButton.innerHTML = '<div class="spinner mx-auto"></div>';
                    submitButton.disabled = true;
                }
            });
        });

        // إخفاء القائمة عند النقر خارجها
        document.addEventListener('click', function(event) {
            const menu = document.getElementById('mobile-menu');
            const button = document.getElementById('mobile-menu-btn');
            
            if (!menu.contains(event.target) && !button.contains(event.target)) {
                menu.classList.add('hidden');
            }
        });

        // تحسين تجربة المستخدم - smooth scrolling
        document.querySelectorAll('a[href^="#"]').forEach(anchor => {
            anchor.addEventListener('click', function (e) {
                e.preventDefault();
                const target = document.querySelector(this.getAttribute('href'));
                if (target) {
                    target.scrollIntoView({
                        behavior: 'smooth',
                        block: 'start'
                    });
                }
            });
        });
    </script>

    @stack('scripts')
</body>
</html>
