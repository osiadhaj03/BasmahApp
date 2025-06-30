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
        Schema::create('articles', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان المقال
            $table->string('slug')->unique(); // رابط ودود
            $table->text('excerpt')->nullable(); // مقتطف
            $table->longText('content'); // محتوى المقال
            $table->string('category'); // التصنيف
            $table->string('featured_image')->nullable(); // صورة بارزة
            $table->json('tags')->nullable(); // العلامات
            $table->boolean('is_featured')->default(false); // مقال مميز
            $table->boolean('is_published')->default(true); // منشور
            $table->integer('views_count')->default(0); // عدد المشاهدات
            $table->integer('likes_count')->default(0); // عدد الإعجابات
            $table->integer('shares_count')->default(0); // عدد المشاركات
            $table->decimal('reading_time', 5, 2)->nullable(); // وقت القراءة بالدقائق
            $table->string('meta_title')->nullable(); // عنوان SEO
            $table->text('meta_description')->nullable(); // وصف SEO
            $table->json('references')->nullable(); // المراجع
            $table->foreignId('author_id')->constrained('users'); // الكاتب
            $table->timestamp('published_at')->nullable(); // تاريخ النشر
            $table->timestamps();
            
            $table->index(['category', 'is_published']);
            $table->index(['is_featured', 'is_published']);
            $table->index(['published_at', 'is_published']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('articles');
    }
};
