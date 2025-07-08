@echo off
chcp 65001 > nul
echo 🚀 بدء عملية النشر السريع...

:: التحقق من أن نحن في مجلد Laravel
if not exist "artisan" (
    echo ❌ خطأ: يجب تشغيل هذا الملف من مجلد Laravel
    pause
    exit /b 1
)

:: التحقق من Git status
echo 📋 التحقق من حالة Git...
git status --porcelain > temp_status.txt
set /p git_status=<temp_status.txt
del temp_status.txt

if not "%git_status%"=="" (
    echo ⚠️  يوجد تغييرات غير محفوظة. سيتم حفظها تلقائياً.
    
    :: إضافة جميع الملفات
    git add .
    
    :: طلب رسالة commit
    set /p commit_message=💬 ادخل رسالة الـ commit أو اضغط Enter للرسالة التلقائية: 
    
    if "%commit_message%"=="" (
        for /f "tokens=1-3 delims=/ " %%a in ('date /t') do set current_date=%%c-%%b-%%a
        for /f "tokens=1-2 delims=: " %%a in ('time /t') do set current_time=%%a:%%b
        set commit_message=update: تحديث !current_date! !current_time!
    )
    
    git commit -m "!commit_message!"
    echo ✅ تم حفظ التغييرات
) else (
    echo ✅ لا توجد تغييرات جديدة
)

:: Push إلى GitHub
echo 📤 رفع التحديثات إلى GitHub...
git push origin main

if %errorlevel% equ 0 (
    echo ✅ تم رفع التحديثات بنجاح!
    echo 🔄 سيتم تحديث الموقع تلقائياً خلال دقائق...
    echo 📊 يمكنك متابعة حالة التحديث في GitHub Actions
    
    :: محاولة فتح GitHub Actions
    for /f "tokens=*" %%i in ('git config --get remote.origin.url') do set repo_url=%%i
    set repo_url=%repo_url:https://github.com/=%
    set repo_url=%repo_url:.git=%
    start "" "https://github.com/%repo_url%/actions"
    
) else (
    echo ❌ فشل في رفع التحديثات!
    echo 💡 تحقق من اتصال الإنترنت وصلاحيات GitHub
    pause
    exit /b 1
)

echo 🎉 تمت العملية بنجاح!
pause
