<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $query = News::with('creator');

        // فلترة حسب النوع
        if ($request->filled('type')) {
            $query->byType($request->type);
        }

        // فلترة حسب الأولوية
        if ($request->filled('priority')) {
            $query->byPriority($request->priority);
        }

        // فلترة حسب حالة النشر
        if ($request->filled('status')) {
            if ($request->status === 'published') {
                $query->where('is_published', true);
            } elseif ($request->status === 'draft') {
                $query->where('is_published', false);
            } elseif ($request->status === 'expired') {
                $query->where('expires_at', '<', now());
            }
        }

        // البحث
        if ($request->filled('search')) {
            $search = $request->search;
            $query->where(function($q) use ($search) {
                $q->where('title', 'like', "%{$search}%")
                  ->orWhere('summary', 'like', "%{$search}%")
                  ->orWhere('content', 'like', "%{$search}%");
            });
        }

        $news = $query->orderBy('created_at', 'desc')->paginate(15);
        $types = News::getTypes();
        $priorities = News::getPriorities();

        return view('admin.news.index', compact('news', 'types', 'priorities'));
    }

    public function create()
    {
        $types = News::getTypes();
        $priorities = News::getPriorities();
        return view('admin.news.create', compact('types', 'priorities'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'content' => 'required|string',
            'type' => 'required|string',
            'priority' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'source' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'expires_at' => 'nullable|date|after:today',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'send_notification' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();
        $data['slug'] = Str::slug($request->title);

        // رفع الصورة البارزة
        if ($request->hasFile('featured_image')) {
            $data['featured_image'] = $request->file('featured_image')->store('news/images', 'public');
        }

        // معالجة الصور الإضافية
        if ($request->hasFile('additional_images')) {
            $images = [];
            foreach ($request->file('additional_images') as $file) {
                $images[] = $file->store('news/images', 'public');
            }
            $data['images'] = $images;
        }

        // معالجة المرفقات
        if ($request->hasFile('attachments')) {
            $attachments = [];
            foreach ($request->file('attachments') as $file) {
                $attachments[] = [
                    'path' => $file->store('news/attachments', 'public'),
                    'name' => $file->getClientOriginalName(),
                    'size' => $file->getSize(),
                ];
            }
            $data['attachments'] = $attachments;
        }

        // تعيين تاريخ النشر
        if ($request->is_published && !$request->published_at) {
            $data['published_at'] = now();
        }

        $news = News::create($data);

        // إرسال إشعار إذا كان مطلوباً
        if ($request->send_notification && $request->is_published) {
            // هنا يمكن إضافة منطق إرسال الإشعارات
            // $this->sendNotification($news);
        }

        return redirect()->route('admin.news.index')
            ->with('success', 'تم إضافة الخبر بنجاح');
    }

    public function show(News $news)
    {
        return view('admin.news.show', compact('news'));
    }

    public function edit(News $news)
    {
        $types = News::getTypes();
        $priorities = News::getPriorities();
        return view('admin.news.edit', compact('news', 'types', 'priorities'));
    }

    public function update(Request $request, News $news)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'summary' => 'nullable|string|max:500',
            'content' => 'required|string',
            'type' => 'required|string',
            'priority' => 'required|string',
            'featured_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'source' => 'nullable|string|max:255',
            'location' => 'nullable|string|max:255',
            'event_date' => 'nullable|date',
            'expires_at' => 'nullable|date|after:today',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'send_notification' => 'boolean',
            'published_at' => 'nullable|date',
        ]);

        $data = $request->all();

        // تحديث الرابط الودود إذا تغير العنوان
        if ($request->title !== $news->title) {
            $data['slug'] = Str::slug($request->title);
        }

        // رفع صورة جديدة
        if ($request->hasFile('featured_image')) {
            // حذف الصورة القديمة
            if ($news->featured_image) {
                Storage::disk('public')->delete($news->featured_image);
            }
            $data['featured_image'] = $request->file('featured_image')->store('news/images', 'public');
        }

        // معالجة الصور الإضافية
        if ($request->hasFile('additional_images')) {
            // حذف الصور القديمة
            if ($news->images) {
                foreach ($news->images as $image) {
                    Storage::disk('public')->delete($image);
                }
            }
            
            $images = [];
            foreach ($request->file('additional_images') as $file) {
                $images[] = $file->store('news/images', 'public');
            }
            $data['images'] = $images;
        }

        // تعيين تاريخ النشر
        if ($request->is_published && !$news->published_at) {
            $data['published_at'] = now();
        }

        $news->update($data);

        return redirect()->route('admin.news.index')
            ->with('success', 'تم تحديث الخبر بنجاح');
    }

    public function destroy(News $news)
    {
        // حذف الملفات المرتبطة
        if ($news->featured_image) {
            Storage::disk('public')->delete($news->featured_image);
        }

        if ($news->images) {
            foreach ($news->images as $image) {
                Storage::disk('public')->delete($image);
            }
        }

        if ($news->attachments) {
            foreach ($news->attachments as $attachment) {
                Storage::disk('public')->delete($attachment['path']);
            }
        }

        $news->delete();

        return redirect()->route('admin.news.index')
            ->with('success', 'تم حذف الخبر بنجاح');
    }

    public function toggleFeatured(News $news)
    {
        $news->update(['is_featured' => !$news->is_featured]);
        
        $status = $news->is_featured ? 'مميز' : 'غير مميز';
        return back()->with('success', "تم تغيير حالة الخبر إلى {$status}");
    }

    public function togglePublished(News $news)
    {
        $wasPublished = $news->is_published;
        $news->update([
            'is_published' => !$news->is_published,
            'published_at' => !$wasPublished ? now() : $news->published_at
        ]);
        
        $status = $news->is_published ? 'منشور' : 'مسودة';
        return back()->with('success', "تم تغيير حالة الخبر إلى {$status}");
    }

    public function preview(News $news)
    {
        return view('admin.news.preview', compact('news'));
    }

    public function urgent()
    {
        $urgentNews = News::urgent()->published()->orderBy('published_at', 'desc')->get();
        return view('admin.news.urgent', compact('urgentNews'));
    }

    public function expired()
    {
        $expiredNews = News::where('expires_at', '<', now())
                          ->orderBy('expires_at', 'desc')
                          ->paginate(15);
        return view('admin.news.expired', compact('expiredNews'));
    }
}
