@echo off
echo ========================================
echo    إنشاء دروس يوم الأربعاء - BasmahApp
echo ========================================
echo.

cd /d "c:\Users\abdul\OneDrive\Documents\BasmahApp"

echo خطوة 1: تشغيل إصلاح قاعدة البيانات...
php quick_fix_database.php

echo.
echo خطوة 2: إنشاء دروس يوم الأربعاء...
php create_wednesday_lessons_simple.php

echo.
echo خطوة 3: تشغيل الخادم...
echo الخادم سيعمل على: http://127.0.0.1:8000
echo.

start http://127.0.0.1:8000/admin/login

echo ========================================
echo           دروس يوم الأربعاء جاهزة!
echo ========================================
echo.
echo للاختبار:
echo.
echo 1. اختبار حفظ الدروس (كمعلم):
echo    البريد: teacher1@basmahapp.com
echo    كلمة المرور: password
echo    - انتقل إلى "الدروس" 
echo    - جرب إنشاء درس جديد
echo    - جرب تعديل درس موجود
echo.
echo 2. اختبار تسجيل الحضور (كطالب):
echo    البريد: student1@basmahapp.com  
echo    كلمة المرور: password
echo    - انتقل إلى لوحة التحكم
echo    - ابحث عن درس "التاريخ - الحضارات القديمة" (4:00 PM)
echo    - جرب تسجيل الحضور
echo.
echo 🎯 درس الساعة 4 العصر متاح الآن للاختبار!
echo.

php artisan serve --host=127.0.0.1 --port=8000
