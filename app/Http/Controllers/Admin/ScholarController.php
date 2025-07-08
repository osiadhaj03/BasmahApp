<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Scholar;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ScholarController extends Controller
{
    /**
     * Display a listing of scholars
     */
    public function index(Request $request)
    {
        $query = Scholar::query();

        // البحث
        if ($request->has('search') && $request->search) {
            $query->where('name', 'LIKE', '%' . $request->search . '%')
                  ->orWhere('specialization', 'LIKE', '%' . $request->search . '%');
        }

        // التصفية حسب الحالة
        if ($request->has('status') && $request->status !== '') {
            $query->where('status', $request->status);
        }

        $scholars = $query->orderBy('created_at', 'desc')->paginate(10);

        return view('admin.scholars.index', compact('scholars'));
    }

    /**
     * Show the form for creating a new scholar
     */
    public function create()
    {
        return view('admin.scholars.create');
    }

    /**
     * Store a newly created scholar
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'specialization' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'birth_date' => 'nullable|date',
            'death_date' => 'nullable|date|after_or_equal:birth_date',
            'status' => 'required|boolean'
        ]);

        // رفع الصورة إذا وجدت
        if ($request->hasFile('photo')) {
            $validated['photo'] = $request->file('photo')->store('scholars', 'public');
        }

        Scholar::create($validated);

        return redirect()->route('admin.scholars.index')
                        ->with('success', 'تم إضافة العالم بنجاح');
    }

    /**
     * Display the specified scholar
     */
    public function show(Scholar $scholar)
    {
        $scholar->load(['courses' => function($query) {
            $query->withCount('lessons');
        }]);

        return view('admin.scholars.show', compact('scholar'));
    }

    /**
     * Show the form for editing the specified scholar
     */
    public function edit(Scholar $scholar)
    {
        return view('admin.scholars.edit', compact('scholar'));
    }

    /**
     * Update the specified scholar
     */
    public function update(Request $request, Scholar $scholar)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'biography' => 'nullable|string',
            'specialization' => 'nullable|string|max:255',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'birth_date' => 'nullable|date',
            'death_date' => 'nullable|date|after_or_equal:birth_date',
            'status' => 'required|boolean'
        ]);

        // رفع الصورة الجديدة إذا وجدت
        if ($request->hasFile('photo')) {
            // حذف الصورة القديمة
            if ($scholar->photo) {
                Storage::disk('public')->delete($scholar->photo);
            }
            $validated['photo'] = $request->file('photo')->store('scholars', 'public');
        }

        $scholar->update($validated);

        return redirect()->route('admin.scholars.index')
                        ->with('success', 'تم تحديث بيانات العالم بنجاح');
    }

    /**
     * Remove the specified scholar
     */
    public function destroy(Scholar $scholar)
    {
        // التحقق من وجود دورات مرتبطة
        if ($scholar->courses()->count() > 0) {
            return redirect()->route('admin.scholars.index')
                            ->with('error', 'لا يمكن حذف العالم لأنه مرتبط بدورات موجودة');
        }

        // حذف الصورة
        if ($scholar->photo) {
            Storage::disk('public')->delete($scholar->photo);
        }

        $scholar->delete();

        return redirect()->route('admin.scholars.index')
                        ->with('success', 'تم حذف العالم بنجاح');
    }

    /**
     * Toggle scholar status
     */
    public function toggleStatus(Scholar $scholar)
    {
        $scholar->update(['status' => !$scholar->status]);

        $message = $scholar->status ? 'تم تفعيل العالم' : 'تم إلغاء تفعيل العالم';

        return redirect()->back()->with('success', $message);
    }
}
