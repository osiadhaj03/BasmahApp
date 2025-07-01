# 🚀 دليل إعداد التحديث التلقائي للموقع

## المشكلة الحالية:
أنت تريد أن يتحديث موقعك على Hostinger تلقائياً كلما تعمل `git push` على الـ main branch.

## الحلول المتاحة:

### ✅ الحل الأول: GitHub Actions (الموصى به)

#### 1. إعداد SSH Key على GitHub:
```bash
# في جهازك المحلي، أنشئ SSH key جديد
ssh-keygen -t rsa -b 4096 -f ~/.ssh/hostinger_deploy

# انسخ المحتوى (سنحتاجه للـ GitHub Secrets)
cat ~/.ssh/hostinger_deploy      # Private Key
cat ~/.ssh/hostinger_deploy.pub  # Public Key
```

#### 2. إضافة SSH Key للـ Hostinger:
- ادخل على cPanel -> SSH Access
- أضف الـ Public Key في قسم "Authorized Keys"

#### 3. إعداد GitHub Secrets:
اذهب إلى GitHub Repository -> Settings -> Secrets and Variables -> Actions

أضف هذه الـ Secrets:
```
HOSTINGER_SSH_KEY = محتوى الـ Private Key كاملاً
```

#### 4. اختبار النظام:
```bash
# في جهازك المحلي
git add .
git commit -m "test: التحديث التلقائي"
git push origin main
```

### ✅ الحل الثاني: GitHub Webhook (بديل)

#### 1. رفع ملف webhook.php للمجلد العام:
```bash
# في السيرفر
cp ~/basmah/webhook.php ~/public_html/deploy.php
```

#### 2. إعداد Webhook في GitHub:
- Repository -> Settings -> Webhooks -> Add webhook
- Payload URL: `https://anwaralolmaa.com/deploy.php`
- Content type: `application/json`
- Secret: كلمة سر قوية
- Events: `Just the push event`

#### 3. تحديث كلمة السر في الملف:
```php
// في ملف deploy.php
$secret = 'ضع_كلمة_سر_قوية_هنا';
```

## 🔧 خطوات الإعداد التفصيلية:

### الخطوة 1: تحضير السيرفر
```bash
# الاتصال بالسيرفر
ssh u994369532@46.202.156.118 -p 65002

# التأكد من وجود Git في مجلد basmah
cd ~/basmah
git status

# إذا لم يكن Git repository، قم بإعداده:
git init
git remote add origin https://github.com/your-username/BasmahApp.git
git pull origin main
```

### الخطوة 2: إعداد Permissions
```bash
# في السيرفر
chmod -R 755 ~/basmah/storage
chmod -R 755 ~/basmah/bootstrap/cache
chmod +x ~/public_html/deploy.php  # إذا استخدمت الـ webhook
```

### الخطوة 3: اختبار النظام
```bash
# في جهازك المحلي
echo "تجربة التحديث التلقائي" > test_deploy.txt
git add .
git commit -m "feat: اختبار نظام التحديث التلقائي"
git push origin main
```

### الخطوة 4: مراقبة النتائج
- **GitHub Actions**: اذهب لـ GitHub -> Actions tab لمشاهدة حالة التحديث
- **Webhook**: تحقق من ملف `deploy.log` في السيرفر

## 🚨 ملاحظات مهمة:

### أمان الموقع:
```bash
# تأكد من أن .env محمي
echo "RewriteEngine On
RewriteRule ^\.env$ - [F,L]" > ~/public_html/.htaccess
```

### Backup قبل التحديث:
```bash
# في السيرفر، أنشئ script backup
cat > ~/backup_before_deploy.sh << 'EOF'
#!/bin/bash
DATE=$(date +%Y%m%d_%H%M%S)
tar -czf ~/backups/backup_$DATE.tar.gz ~/basmah ~/public_html
echo "Backup created: backup_$DATE.tar.gz"
EOF

chmod +x ~/backup_before_deploy.sh
```

### مراقبة الأخطاء:
```bash
# إنشاء ملف لمراقبة أخطاء Laravel
touch ~/basmah/storage/logs/laravel.log
tail -f ~/basmah/storage/logs/laravel.log
```

## 🎯 الخطوات التالية:

1. **اختر الحل المناسب** (GitHub Actions موصى به)
2. **اتبع خطوات الإعداد** حسب الحل المختار
3. **اختبر النظام** بعمل push صغير
4. **راقب النتائج** واتأكد من نجاح التحديث

## 🆘 حل المشاكل الشائعة:

### مشكلة Permissions:
```bash
chmod -R 755 ~/basmah/storage ~/basmah/bootstrap/cache
chown -R $USER:$USER ~/basmah
```

### مشكلة Composer:
```bash
# في السيرفر
cd ~/basmah
composer install --no-dev --optimize-autoloader
```

### مشكلة Database:
```bash
# تحقق من اتصال قاعدة البيانات
php artisan tinker
>>> DB::connection()->getPdo();
```

---

**💡 نصيحة:** ابدأ بالـ GitHub Actions لأنه أكثر أماناً وموثوقية!
