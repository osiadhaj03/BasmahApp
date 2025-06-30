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
        Schema::create('books', function (Blueprint $table) {
            $table->id();
            $table->string('title'); // عنوان الكتاب
            $table->string('author'); // المؤلف
            $table->text('description')->nullable(); // وصف الكتاب
            $table->string('category'); // التصنيف (فقه، عقيدة، حديث، إلخ)
            $table->string('cover_image')->nullable(); // صورة الغلاف
            $table->string('file_path')->nullable(); // مسار ملف الكتاب PDF
            $table->string('download_url')->nullable(); // رابط التحميل الخارجي
            $table->integer('pages')->nullable(); // عدد الصفحات
            $table->string('language')->default('ar'); // اللغة
            $table->boolean('is_featured')->default(false); // كتاب مميز
            $table->boolean('is_published')->default(true); // منشور
            $table->integer('download_count')->default(0); // عدد مرات التحميل
            $table->decimal('rating', 3, 2)->nullable(); // التقييم
            $table->json('tags')->nullable(); // العلامات
            $table->foreignId('created_by')->constrained('users'); // من أضافه
            $table->timestamps();
            
            $table->index(['category', 'is_published']);
            $table->index(['is_featured', 'is_published']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};
