<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان الخبر
            $table->string('slug')->unique(); // رابط ودود
            $table->text('summary')->nullable(); // ملخص
            $table->longText('content'); // محتوى الخبر
            $table->string('type')->default('general'); // نوع الخبر (عام، إعلان، تحديث، إلخ)
            $table->string('priority')->default('normal'); // الأولوية (عاجل، عادي، منخفض)
            $table->string('featured_image')->nullable(); // صورة بارزة
            $table->json('images')->nullable(); // صور إضافية
            $table->json('attachments')->nullable(); // مرفقات
            $table->boolean('is_featured')->default(false); // خبر مميز
            $table->boolean('is_published')->default(true); // منشور
            $table->boolean('send_notification')->default(false); // إرسال إشعار
            $table->integer('views_count')->default(0); // عدد المشاهدات
            $table->string('source')->nullable(); // المصدر
            $table->string('location')->nullable(); // الموقع
            $table->timestamp('event_date')->nullable(); // تاريخ الحدث
            $table->timestamp('expires_at')->nullable(); // تاريخ انتهاء الصلاحية
            $table->foreignId('created_by')->constrained('users'); // من أضافه
            $table->timestamp('published_at')->nullable(); // تاريخ النشر
            $table->timestamps();
            
            $table->index(['type', 'is_published']);
            $table->index(['priority', 'is_published']);
            $table->index(['is_featured', 'is_published']);
            $table->index(['published_at', 'is_published']);
            $table->index(['expires_at', 'is_published']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};
