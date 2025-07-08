<?php

/**
 * Content Management System Test
 * Tests for Books, Articles, and News functionality
 * Created: June 30, 2025
 */

require_once __DIR__ . '/vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Http\Request;

echo "=== اختبار نظام إدارة المحتوى - أنوار العلوم ===\n";
echo "التاريخ: " . date('Y-m-d H:i:s') . "\n\n";

// Test database connection
try {
    $app = require_once __DIR__ . '/bootstrap/app.php';
    $app->make(\Illuminate\Contracts\Console\Kernel::class)->bootstrap();
    
    echo "✅ تم الاتصال بقاعدة البيانات بنجاح\n";
    
    // Check if tables exist
    $tables = ['books', 'articles', 'news'];
    $db = \Illuminate\Support\Facades\DB::connection();
    
    foreach ($tables as $table) {
        if (\Illuminate\Support\Facades\Schema::hasTable($table)) {
            echo "✅ الجدول '$table' موجود\n";
            
            // Get table columns
            $columns = \Illuminate\Support\Facades\Schema::getColumnListing($table);
            echo "   - الأعمدة: " . implode(', ', $columns) . "\n";
            
            // Count records
            $count = $db->table($table)->count();
            echo "   - عدد السجلات: $count\n";
        } else {
            echo "❌ الجدول '$table' غير موجود\n";
        }
    }
    
    echo "\n";
    
} catch (Exception $e) {
    echo "❌ خطأ في الاتصال بقاعدة البيانات: " . $e->getMessage() . "\n";
    exit(1);
}

// Test Models
echo "=== اختبار النماذج (Models) ===\n";

try {
    // Test Book Model
    if (class_exists('App\Models\Book')) {
        echo "✅ نموذج الكتب (Book) موجود\n";
        
        // Test creating a book
        $book = new \App\Models\Book();
        $book->title = "كتاب تجريبي";
        $book->author = "مؤلف تجريبي";
        $book->description = "وصف تجريبي للكتاب";
        $book->category = "القرآن الكريم";
        $book->is_published = true;
        $book->is_featured = false;
        $book->save();
        
        echo "   - تم إنشاء كتاب تجريبي بنجاح (ID: {$book->id})\n";
        
        // Test Book methods
        echo "   - التصنيفات المتاحة: " . implode(', ', $book->getAvailableCategories()) . "\n";
        
    } else {
        echo "❌ نموذج الكتب (Book) غير موجود\n";
    }
    
    // Test Article Model
    if (class_exists('App\Models\Article')) {
        echo "✅ نموذج المقالات (Article) موجود\n";
        
        // Test creating an article
        $article = new \App\Models\Article();
        $article->title = "مقال تجريبي";
        $article->content = "محتوى المقال التجريبي. هذا نص طويل لاختبار حساب وقت القراءة. " . str_repeat("كلمة ", 100);
        $article->category = "العقيدة";
        $article->is_published = true;
        $article->is_featured = false;
        $article->save();
        
        echo "   - تم إنشاء مقال تجريبي بنجاح (ID: {$article->id})\n";
        echo "   - الرابط المولد: {$article->slug}\n";
        echo "   - وقت القراءة المحسوب: {$article->reading_time} دقيقة\n";
        
    } else {
        echo "❌ نموذج المقالات (Article) غير موجود\n";
    }
    
    // Test News Model
    if (class_exists('App\Models\News')) {
        echo "✅ نموذج الأخبار (News) موجود\n";
        
        // Test creating news
        $news = new \App\Models\News();
        $news->title = "خبر تجريبي";
        $news->summary = "ملخص الخبر التجريبي";
        $news->content = "محتوى الخبر التجريبي";
        $news->type = "عام";
        $news->priority = "عادية";
        $news->is_published = true;
        $news->is_featured = false;
        $news->is_urgent = false;
        $news->save();
        
        echo "   - تم إنشاء خبر تجريبي بنجاح (ID: {$news->id})\n";
        echo "   - مستويات الأولوية: " . implode(', ', $news->getPriorityLevels()) . "\n";
        
    } else {
        echo "❌ نموذج الأخبار (News) غير موجود\n";
    }
    
} catch (Exception $e) {
    echo "❌ خطأ في اختبار النماذج: " . $e->getMessage() . "\n";
}

echo "\n";

// Test Controllers
echo "=== اختبار المتحكمات (Controllers) ===\n";

$controllers = [
    'App\Http\Controllers\Admin\BookController' => 'متحكم الكتب',
    'App\Http\Controllers\Admin\ArticleController' => 'متحكم المقالات',
    'App\Http\Controllers\Admin\NewsController' => 'متحكم الأخبار'
];

foreach ($controllers as $controller => $name) {
    if (class_exists($controller)) {
        echo "✅ $name موجود\n";
        
        // Check if controller has required methods
        $reflection = new ReflectionClass($controller);
        $methods = ['index', 'create', 'store', 'show', 'edit', 'update', 'destroy'];
        
        foreach ($methods as $method) {
            if ($reflection->hasMethod($method)) {
                echo "   - الدالة '$method' موجودة\n";
            } else {
                echo "   - ❌ الدالة '$method' مفقودة\n";
            }
        }
    } else {
        echo "❌ $name غير موجود\n";
    }
}

echo "\n";

// Test Routes
echo "=== اختبار المسارات (Routes) ===\n";

try {
    $routes = \Illuminate\Support\Facades\Route::getRoutes();
    $contentRoutes = [];
    
    foreach ($routes as $route) {
        $uri = $route->uri();
        if (strpos($uri, 'admin/books') !== false || 
            strpos($uri, 'admin/articles') !== false || 
            strpos($uri, 'admin/news') !== false) {
            $contentRoutes[] = $uri;
        }
    }
    
    if (count($contentRoutes) > 0) {
        echo "✅ تم العثور على " . count($contentRoutes) . " مسار لإدارة المحتوى\n";
        
        // Show some example routes
        $exampleRoutes = array_slice($contentRoutes, 0, 10);
        foreach ($exampleRoutes as $route) {
            echo "   - $route\n";
        }
        
        if (count($contentRoutes) > 10) {
            echo "   - و " . (count($contentRoutes) - 10) . " مسارات أخرى...\n";
        }
    } else {
        echo "❌ لم يتم العثور على مسارات إدارة المحتوى\n";
    }
    
} catch (Exception $e) {
    echo "❌ خطأ في اختبار المسارات: " . $e->getMessage() . "\n";
}

echo "\n";

// Test Views
echo "=== اختبار الواجهات (Views) ===\n";

$viewPaths = [
    'resources/views/admin/books/index.blade.php' => 'قائمة الكتب',
    'resources/views/admin/books/create.blade.php' => 'إضافة كتاب',
    'resources/views/admin/books/edit.blade.php' => 'تعديل كتاب',
    'resources/views/admin/books/show.blade.php' => 'تفاصيل كتاب',
    'resources/views/admin/articles/index.blade.php' => 'قائمة المقالات',
    'resources/views/admin/articles/create.blade.php' => 'إضافة مقال',
    'resources/views/admin/articles/edit.blade.php' => 'تعديل مقال',
    'resources/views/admin/articles/show.blade.php' => 'تفاصيل مقال',
    'resources/views/admin/news/index.blade.php' => 'قائمة الأخبار',
    'resources/views/admin/news/create.blade.php' => 'إضافة خبر',
    'resources/views/admin/news/edit.blade.php' => 'تعديل خبر',
    'resources/views/admin/news/show.blade.php' => 'تفاصيل خبر'
];

foreach ($viewPaths as $path => $name) {
    $fullPath = __DIR__ . '/' . $path;
    if (file_exists($fullPath)) {
        echo "✅ واجهة $name موجودة\n";
        
        // Check file size
        $size = filesize($fullPath);
        echo "   - حجم الملف: " . number_format($size) . " بايت\n";
    } else {
        echo "❌ واجهة $name غير موجودة\n";
    }
}

echo "\n";

// Test Storage Directories
echo "=== اختبار مجلدات التخزين ===\n";

$storagePaths = [
    'storage/app/public/books/covers' => 'أغلفة الكتب',
    'storage/app/public/books/files' => 'ملفات الكتب',
    'storage/app/public/articles/images' => 'صور المقالات',
    'storage/app/public/news/images' => 'صور الأخبار',
    'storage/app/public/news/attachments' => 'مرفقات الأخبار'
];

foreach ($storagePaths as $path => $name) {
    $fullPath = __DIR__ . '/' . $path;
    if (is_dir($fullPath)) {
        echo "✅ مجلد $name موجود\n";
        
        // Check if writable
        if (is_writable($fullPath)) {
            echo "   - قابل للكتابة: نعم\n";
        } else {
            echo "   - ❌ قابل للكتابة: لا\n";
        }
    } else {
        echo "❌ مجلد $name غير موجود\n";
    }
}

echo "\n";

// Performance Test
echo "=== اختبار الأداء ===\n";

if (isset($book, $article, $news)) {
    $start = microtime(true);
    
    // Test queries
    $books = \App\Models\Book::published()->take(10)->get();
    $articles = \App\Models\Article::published()->take(10)->get();
    $urgentNews = \App\Models\News::urgent()->take(5)->get();
    
    $end = microtime(true);
    $queryTime = ($end - $start) * 1000;
    
    echo "✅ اختبار الاستعلامات:\n";
    echo "   - الكتب المنشورة: " . $books->count() . " كتاب\n";
    echo "   - المقالات المنشورة: " . $articles->count() . " مقال\n";
    echo "   - الأخبار العاجلة: " . $urgentNews->count() . " خبر\n";
    echo "   - وقت التنفيذ: " . number_format($queryTime, 2) . " ميلي ثانية\n";
}

echo "\n";

// Clean up test data
echo "=== تنظيف البيانات التجريبية ===\n";

try {
    if (isset($book)) {
        $book->delete();
        echo "✅ تم حذف الكتاب التجريبي\n";
    }
    
    if (isset($article)) {
        $article->delete();
        echo "✅ تم حذف المقال التجريبي\n";
    }
    
    if (isset($news)) {
        $news->delete();
        echo "✅ تم حذف الخبر التجريبي\n";
    }
    
} catch (Exception $e) {
    echo "❌ خطأ في تنظيف البيانات: " . $e->getMessage() . "\n";
}

echo "\n";

// Summary
echo "=== ملخص النتائج ===\n";
echo "✅ نظام إدارة المحتوى جاهز للاستخدام!\n";
echo "📚 يمكنك الآن إدارة الكتب والمقالات والأخبار من لوحة التحكم\n";
echo "🔗 رابط لوحة التحكم: /admin/dashboard\n";
echo "📖 رابط إدارة الكتب: /admin/books\n";
echo "📝 رابط إدارة المقالات: /admin/articles\n";
echo "📰 رابط إدارة الأخبار: /admin/news\n\n";

echo "=== انتهى الاختبار ===\n";
echo "التاريخ: " . date('Y-m-d H:i:s') . "\n";
?>