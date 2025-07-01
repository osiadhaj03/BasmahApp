#!/bin/bash

# 🚀 Basmah App - Quick Deploy Script
# هذا الـ script يساعدك في نشر التحديثات بسرعة

echo "🚀 بدء عملية النشر السريع..."

# ألوان للرسائل
GREEN='\033[0;32m'
YELLOW='\033[1;33m'
RED='\033[0;31m'
NC='\033[0m' # No Color

# التحقق من أن نحن في مجلد المشروع
if [ ! -f "artisan" ]; then
    echo -e "${RED}❌ خطأ: يجب تشغيل هذا الـ script من مجلد Laravel${NC}"
    exit 1
fi

# التحقق من Git status
echo -e "${YELLOW}📋 التحقق من حالة Git...${NC}"
if [ -n "$(git status --porcelain)" ]; then
    echo -e "${YELLOW}⚠️  يوجد تغييرات غير محفوظة. سيتم حفظها تلقائياً.${NC}"
    
    # إضافة جميع الملفات
    git add .
    
    # طلب رسالة commit
    echo -n "💬 ادخل رسالة الـ commit (أو اضغط Enter للرسالة التلقائية): "
    read commit_message
    
    if [ -z "$commit_message" ]; then
        commit_message="update: تحديث $(date '+%Y-%m-%d %H:%M')"
    fi
    
    git commit -m "$commit_message"
    echo -e "${GREEN}✅ تم حفظ التغييرات${NC}"
else
    echo -e "${GREEN}✅ لا توجد تغييرات جديدة${NC}"
fi

# Push إلى GitHub
echo -e "${YELLOW}📤 رفع التحديثات إلى GitHub...${NC}"
git push origin main

if [ $? -eq 0 ]; then
    echo -e "${GREEN}✅ تم رفع التحديثات بنجاح!${NC}"
    echo -e "${YELLOW}🔄 سيتم تحديث الموقع تلقائياً خلال دقائق...${NC}"
    echo -e "${YELLOW}📊 يمكنك متابعة حالة التحديث في GitHub Actions${NC}"
    
    # فتح GitHub Actions (إذا كان متاحاً)
    if command -v xdg-open &> /dev/null; then
        xdg-open "https://github.com/$(git config --get remote.origin.url | sed 's/.*:\/\/github.com\///' | sed 's/\.git$//')/actions"
    elif command -v open &> /dev/null; then
        open "https://github.com/$(git config --get remote.origin.url | sed 's/.*:\/\/github.com\///' | sed 's/\.git$//')/actions"
    fi
    
else
    echo -e "${RED}❌ فشل في رفع التحديثات!${NC}"
    echo -e "${YELLOW}💡 تحقق من اتصال الإنترنت وصلاحيات GitHub${NC}"
    exit 1
fi

echo -e "${GREEN}🎉 تمت العملية بنجاح!${NC}"
