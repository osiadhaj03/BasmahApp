<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ArticleController extends Controller
{
    public function index(Request $request)
    {
        $query = Article::with('author');

        // فلترة حسب التصنيف
        if ($request->filled('category')) {
            $query->byCategory($request->category);
        }

        // فلترة حسب حالة النشر
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            }
        }

        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('excerpt', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $articles = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = Article::getCategories();

        return view('admin.articles.index', compact('articles', 'categories'));
    }

    public function create()
    {
        $categories = Article::getCategories();
        return view('admin.articles.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|string',
            'references' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['author_id'] = auth()->id();
        $data['slug'] = Str::slug($request->title);

        // رفع الصورة البارزة
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('articles/images', 'public');
        }

        // تحويل العلامات إلى مصفوفة
        if ($request->filled('tags')) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // تحويل المراجع إلى مصفوفة
        if ($request->filled('references')) {
            $references = explode("\n", $request->references);
            $data['references'] = array_map('trim', array_filter($references));
        }

        // تعيين تاريخ النشر
        if ($request->is_published && !$request->published_at) {
            $data['published_at'] = now();
        }

        $article = Article::create($data);
        
        // حساب وقت القراءة
        $article->calculateReadingTime();

        return redirect()->route('admin.articles.index')
            ->with('success', 'تم إضافة المقال بنجاح');
    }

    public function show(Article $article)
    {
        return view('admin.articles.show', compact('article'));
    }

    public function edit(Article $article)
    {
        $categories = Article::getCategories();
        return view('admin.articles.edit', compact('article', 'categories'));
    }

    public function update(Request $request, Article $article)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'excerpt' => 'nullable|string|max:500',
            'content' => 'required|string',
            'category' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'meta_title' => 'nullable|string|max:255',
            'meta_description' => 'nullable|string|max:500',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'published_at' => 'nullable|date',
            'tags' => 'nullable|string',
            'references' => 'nullable|string',
        ]);

        $data = $request->all();

        // تحديث الرابط الودود إذا تغير العنوان
        if ($request->title !== $article->title) {
            $data['slug'] = Str::slug($request->title);
        }

        // رفع صورة جديدة
        if ($request->hasFile('featured_image')) {
            // حذف الصورة القديمة
            if ($article->featured_image) {
                Storage::disk('public')->delete($article->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('articles/images', 'public');
        }

        // تحويل العلامات إلى مصفوفة
        if ($request->filled('tags')) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        // تحويل المراجع إلى مصفوفة
        if ($request->filled('references')) {
            $references = explode("\n", $request->references);
            $data['references'] = array_map('trim', array_filter($references));
        }

        // تعيين تاريخ النشر
        if ($request->is_published && !$article->published_at) {
            $data['published_at'] = now();
        }

        $article->update($data);
        
        // إعادة حساب وقت القراءة
        $article->calculateReadingTime();

        return redirect()->route('admin.articles.index')
            ->with('success', 'تم تحديث المقال بنجاح');
    }

    public function destroy(Article $article)
    {
        // حذف الصورة المرتبطة
        if ($article->featured_image) {
            Storage::disk('public')->delete($article->featured_image);
        }

        $article->delete();

        return redirect()->route('admin.articles.index')
            ->with('success', 'تم حذف المقال بنجاح');
    }

    public function toggleFeatured(Article $article)
    {
        $article->update(['is_featured' => !$article->is_featured]);
        
        $status = $article->is_featured ? 'مميز' : 'غير مميز';
        return back()->with('success', "تم تغيير حالة المقال إلى {$status}");
    }

    public function togglePublished(Article $article)
    {
        $wasPublished = $article->is_published;
        $article->update([
            'is_published' => !$article->is_published,
            'published_at' => !$wasPublished ? now() : $article->published_at
        ]);
        
        $status = $article->is_published ? 'منشور' : 'مسودة';
        return back()->with('success', "تم تغيير حالة المقال إلى {$status}");
    }

    public function preview(Article $article)
    {
        return view('admin.articles.preview', compact('article'));
    }
}
