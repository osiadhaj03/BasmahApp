<?php

require_once 'vendor/autoload.php';

$app = require_once 'bootstrap/app.php';
$app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();

use App\Models\User;
use Illuminate\Support\Facades\Hash;

try {
    echo "🕌 إنشاء حساب مدير لمنصة أنوار العلوم 🕌\n";
    echo "=" . str_repeat("=", 50) . "\n\n";
    
    // Check database connection
    $users_count = User::count();
    echo "📊 عدد المستخدمين الحاليين: " . $users_count . "\n\n";
    
    // Create additional admin user with Arabic name
    $arabicAdmin = User::where('email', 'admin@anwaraloloom.com')->first();
    
    if ($arabicAdmin) {
        echo "✅ المدير موجود بالفعل: admin@anwaraloloom.com\n";
    } else {
        $arabicAdmin = User::create([
            'name' => 'مدير أنوار العلوم',
            'email' => 'admin@anwaraloloom.com',
            'password' => Hash::make('admin123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        
        echo "✅ تم إنشاء حساب المدير بنجاح!\n";
        echo "   الاسم: مدير أنوار العلوم\n";
        echo "   البريد الإلكتروني: admin@anwaraloloom.com\n";
        echo "   كلمة المرور: admin123\n";
        echo "   الصلاحية: مدير\n\n";
    }
    
    // Create a secondary admin account
    $secondAdmin = User::where('email', 'supervisor@anwaraloloom.com')->first();
    
    if (!$secondAdmin) {
        $secondAdmin = User::create([
            'name' => 'المشرف العام',
            'email' => 'supervisor@anwaraloloom.com',
            'password' => Hash::make('supervisor123'),
            'role' => 'admin',
            'email_verified_at' => now(),
        ]);
        
        echo "✅ تم إنشاء حساب المشرف العام بنجاح!\n";
        echo "   الاسم: المشرف العام\n";
        echo "   البريد الإلكتروني: supervisor@anwaraloloom.com\n";
        echo "   كلمة المرور: supervisor123\n";
        echo "   الصلاحية: مدير\n\n";
    }
    
    echo "🎯 جميع حسابات المديرين:\n";
    echo "-" . str_repeat("-", 40) . "\n";
    
    $allAdmins = User::where('role', 'admin')->get();
    foreach ($allAdmins as $admin) {
        echo "👤 " . $admin->name . " (" . $admin->email . ")\n";
    }
    
    echo "\n📝 معلومات تسجيل الدخول:\n";
    echo "-" . str_repeat("-", 40) . "\n";
    echo "🌐 رابط تسجيل الدخول: http://localhost:8000/admin/login\n";
    echo "📧 البريد الإلكتروني: admin@anwaraloloom.com\n";
    echo "🔑 كلمة المرور: admin123\n";
    echo "\n🕌 مرحباً بك في منصة أنوار العلوم التعليمية الإسلامية! 🕌\n";
    
} catch (Exception $e) {
    echo "❌ خطأ في إنشاء حساب المدير: " . $e->getMessage() . "\n";
    echo "📍 الملف: " . $e->getFile() . "\n";
    echo "📍 السطر: " . $e->getLine() . "\n";
}
