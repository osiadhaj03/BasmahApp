@echo off
chcp 65001 > nul
echo.
echo ================================
echo 🚀 Basmah App - نشر سريع 
echo ================================
echo.

:: التحقق من أن نحن في مجلد Laravel
if not exist "artisan" (
    echo ❌ خطأ: يجب تشغيل هذا الملف من مجلد Laravel
    pause
    exit /b 1
)

:: إضافة جميع الملفات
echo 📋 إضافة الملفات الجديدة...
git add .

:: طلب رسالة commit
set /p "commit_message=💬 ادخل رسالة الـ commit (أو Enter للتلقائية): "

if "%commit_message%"=="" (
    set "commit_message=feat: إضافة نظام التحديث التلقائي وتحسينات الإدارة"
)

:: Commit التغييرات
echo 💾 حفظ التغييرات...
git commit -m "%commit_message%"

:: Push إلى GitHub
echo 📤 رفع التحديثات إلى GitHub...
git push origin main

if %errorlevel% equ 0 (
    echo.
    echo ✅ تم رفع التحديثات بنجاح!
    echo 🔄 سيتم تحديث الموقع تلقائياً خلال دقائق...
    echo 📊 متابعة حالة التحديث:
    echo    👉 https://github.com/OsamaElshaer/BasmahApp/actions
    echo.
    echo 🌐 الموقع: https://anwaralolmaa.com
    echo.
    
    :: فتح GitHub Actions
    start "" "https://github.com/OsamaElshaer/BasmahApp/actions"
    
) else (
    echo.
    echo ❌ فشل في رفع التحديثات!
    echo 💡 تحقق من:
    echo    - اتصال الإنترنت
    echo    - صلاحيات GitHub
    echo    - إعدادات Git
    echo.
    pause
    exit /b 1
)

echo 🎉 تمت العملية بنجاح!
echo ⏰ انتظر حوالي دقيقتين لتحديث الموقع...
pause
