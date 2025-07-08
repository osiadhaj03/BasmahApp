<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CourseCategory;
use Illuminate\Http\Request;

class CourseCategoryController extends Controller
{
    /**
     * Display a listing of course categories
     */
    public function index(Request $request)
    {
        $query = CourseCategory::withCount('courses');

        // البحث
        if ($request->has('search') && $request->search) {
            $query->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('description', 'LIKE', '%' . $request->search . '%');
        }

        // التصفية حسب الحالة
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $categories = $query->ordered()->paginate(10);

        return view('admin.course-categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new category
     */
    public function create()
    {
        return view('admin.course-categories.create');
    }

    /**
     * Store a newly created category
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:course_categories',
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'color' => 'required|string|max:7',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|boolean'
        ]);

        // تعيين ترتيب تلقائي إذا لم يتم تحديده
        if (!isset($validated['sort_order'])) {
            $validated['sort_order'] = CourseCategory::max('sort_order') + 1;
        }

        CourseCategory::create($validated);

        return redirect()->route('admin.course-categories.index')
                        ->with('success', 'تم إضافة قسم الدورات بنجاح');
    }

    /**
     * Display the specified category
     */
    public function show(CourseCategory $courseCategory)
    {
        $courseCategory->load(['courses' => function($query) {
            $query->with('scholar')->withCount('lessons');
        }]);

        return view('admin.course-categories.show', compact('courseCategory'));
    }

    /**
     * Show the form for editing the specified category
     */
    public function edit(CourseCategory $courseCategory)
    {
        return view('admin.course-categories.edit', compact('courseCategory'));
    }

    /**
     * Update the specified category
     */
    public function update(Request $request, CourseCategory $courseCategory)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255|unique:course_categories,name,' . $courseCategory->id,
            'description' => 'nullable|string',
            'icon' => 'nullable|string|max:100',
            'color' => 'required|string|max:7',
            'sort_order' => 'nullable|integer|min:0',
            'status' => 'required|boolean'
        ]);

        $courseCategory->update($validated);

        return redirect()->route('admin.course-categories.index')
                        ->with('success', 'تم تحديث قسم الدورات بنجاح');
    }

    /**
     * Remove the specified category
     */
    public function destroy(CourseCategory $courseCategory)
    {
        // التحقق من وجود دورات مرتبطة
        if ($courseCategory->courses()->count() > 0) {
            return redirect()->route('admin.course-categories.index')
                            ->with('error', 'لا يمكن حذف القسم لأنه يحتوي على دورات');
        }

        $courseCategory->delete();

        return redirect()->route('admin.course-categories.index')
                        ->with('success', 'تم حذف قسم الدورات بنجاح');
    }

    /**
     * Toggle category status
     */
    public function toggleStatus(CourseCategory $courseCategory)
    {
        $courseCategory->update(['status' => !$courseCategory->status]);

        $message = $courseCategory->status ? 'تم تفعيل القسم' : 'تم إلغاء تفعيل القسم';

        return redirect()->back()->with('success', $message);
    }

    /**
     * Update categories order
     */
    public function updateOrder(Request $request)
    {
        $validated = $request->validate([
            'categories' => 'required|array',
            'categories.*.id' => 'required|exists:course_categories,id',
            'categories.*.sort_order' => 'required|integer|min:0'
        ]);

        foreach ($validated['categories'] as $categoryData) {
            CourseCategory::where('id', $categoryData['id'])
                         ->update(['sort_order' => $categoryData['sort_order']]);
        }

        return response()->json(['success' => true, 'message' => 'تم تحديث ترتيب الأقسام بنجاح']);
    }
}
