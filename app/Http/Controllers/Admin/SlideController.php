<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Slide;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SlideController extends Controller
{
    public function index()
    {
        $slides = Slide::orderBy('sort_order')->paginate(12);
        return view('admin.slides.index', compact('slides'));
    }

    public function create()
    {
        $slide = new Slide();
        return view('admin.slides.create', compact('slide'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:150',
            'caption' => 'nullable|string|max:255',
            'image' => 'required|image|mimes:jpg,jpeg,png,webp|max:10240', // up to 10MB
            'status' => 'required|in:draft,published',
            'sort_order' => 'nullable|integer|min:0',
            'interval_ms' => 'nullable|integer|min:1000|max:60000',
        ]);

        $path = $request->file('image')->store('slides', 'public');

        Slide::create([
            'title' => $validated['title'] ?? null,
            'caption' => $validated['caption'] ?? null,
            'image_path' => $path,
            'status' => $validated['status'],
            'sort_order' => $validated['sort_order'] ?? 0,
            'interval_ms' => $validated['interval_ms'] ?? null,
        ]);

        return redirect()->route('admin.slides.index')->with('success', 'Slide berhasil dibuat');
    }

    public function edit(Slide $slide)
    {
        return view('admin.slides.edit', compact('slide'));
    }

    public function update(Request $request, Slide $slide)
    {
        $validated = $request->validate([
            'title' => 'nullable|string|max:150',
            'caption' => 'nullable|string|max:255',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:10240', // up to 10MB
            'status' => 'required|in:draft,published',
            'sort_order' => 'nullable|integer|min:0',
            'interval_ms' => 'nullable|integer|min:1000|max:60000',
        ]);

        if ($request->hasFile('image')) {
            // delete old
            if ($slide->image_path && Storage::disk('public')->exists($slide->image_path)) {
                Storage::disk('public')->delete($slide->image_path);
            }
            $slide->image_path = $request->file('image')->store('slides', 'public');
        }

        $slide->title = $validated['title'] ?? null;
        $slide->caption = $validated['caption'] ?? null;
        $slide->status = $validated['status'];
        $slide->sort_order = $validated['sort_order'] ?? 0;
        $slide->interval_ms = $validated['interval_ms'] ?? null;
        $slide->save();

        return redirect()->route('admin.slides.index')->with('success', 'Slide berhasil diperbarui');
    }

    public function destroy(Slide $slide)
    {
        if ($slide->image_path && Storage::disk('public')->exists($slide->image_path)) {
            Storage::disk('public')->delete($slide->image_path);
        }
        $slide->delete();
        return redirect()->route('admin.slides.index')->with('success', 'Slide dihapus');
    }
}