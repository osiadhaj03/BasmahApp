<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Book;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class BookController extends Controller
{
    public function index(Request $request)
    {
        $query = Book::with('creator');

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
                  ->orWhere('author', 'like', "%{$search}%")
                  ->orWhere('description', 'like', "%{$search}%");
            });
        }

        $books = $query->orderBy('created_at', 'desc')->paginate(15);
        $categories = Book::getCategories();

        return view('admin.books.index', compact('books', 'categories'));
    }

    public function create()
    {
        $categories = Book::getCategories();
        return view('admin.books.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'book_file' => 'nullable|file|mimes:pdf|max:20480', // 20MB
            'download_url' => 'nullable|url',
            'pages' => 'nullable|integer|min:1',
            'language' => 'required|string|max:10',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'tags' => 'nullable|string',
        ]);

        $data = $request->all();
        $data['created_by'] = auth()->id();

        // رفع صورة الغلاف
        if ($request->hasFile('cover_image')) {
            $data['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        // رفع ملف الكتاب
        if ($request->hasFile('book_file')) {
            $data['file_path'] = $request->file('book_file')->store('books/files', 'public');
        }

        // تحويل العلامات إلى مصفوفة
        if ($request->filled('tags')) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        Book::create($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'تم إضافة الكتاب بنجاح');
    }

    public function show(Book $book)
    {
        return view('admin.books.show', compact('book'));
    }

    public function edit(Book $book)
    {
        $categories = Book::getCategories();
        return view('admin.books.edit', compact('book', 'categories'));
    }

    public function update(Request $request, Book $book)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'author' => 'required|string|max:255',
            'description' => 'nullable|string',
            'category' => 'required|string',
            'cover_image' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'book_file' => 'nullable|file|mimes:pdf|max:20480',
            'download_url' => 'nullable|url',
            'pages' => 'nullable|integer|min:1',
            'language' => 'required|string|max:10',
            'is_featured' => 'boolean',
            'is_published' => 'boolean',
            'tags' => 'nullable|string',
        ]);

        $data = $request->all();

        // رفع صورة غلاف جديدة
        if ($request->hasFile('cover_image')) {
            // حذف الصورة القديمة
            if ($book->cover_image) {
                Storage::disk('public')->delete($book->cover_image);
            }
            $data['cover_image'] = $request->file('cover_image')->store('books/covers', 'public');
        }

        // رفع ملف كتاب جديد
        if ($request->hasFile('book_file')) {
            // حذف الملف القديم
            if ($book->file_path) {
                Storage::disk('public')->delete($book->file_path);
            }
            $data['file_path'] = $request->file('book_file')->store('books/files', 'public');
        }

        // تحويل العلامات إلى مصفوفة
        if ($request->filled('tags')) {
            $data['tags'] = array_map('trim', explode(',', $request->tags));
        }

        $book->update($data);

        return redirect()->route('admin.books.index')
            ->with('success', 'تم تحديث الكتاب بنجاح');
    }

    public function destroy(Book $book)
    {
        // حذف الملفات المرتبطة
        if ($book->cover_image) {
            Storage::disk('public')->delete($book->cover_image);
        }
        if ($book->file_path) {
            Storage::disk('public')->delete($book->file_path);
        }

        $book->delete();

        return redirect()->route('admin.books.index')
            ->with('success', 'تم حذف الكتاب بنجاح');
    }

    public function download(Book $book)
    {
        $book->incrementDownloadCount();

        if ($book->file_path) {
            return Storage::disk('public')->download($book->file_path, $book->title . '.pdf');
        } elseif ($book->download_url) {
            return redirect($book->download_url);
        }

        return back()->with('error', 'الكتاب غير متوفر للتحميل');
    }

    public function toggleFeatured(Book $book)
    {
        $book->update(['is_featured' => !$book->is_featured]);
        
        $status = $book->is_featured ? 'مميز' : 'غير مميز';
        return back()->with('success', "تم تغيير حالة الكتاب إلى {$status}");
    }

    public function togglePublished(Book $book)
    {
        $book->update(['is_published' => !$book->is_published]);
        
        $status = $book->is_published ? 'منشور' : 'مسودة';
        return back()->with('success', "تم تغيير حالة الكتاب إلى {$status}");
    }
}
