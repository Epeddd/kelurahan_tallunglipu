<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Gallery;
use App\Models\GalleryImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class GalleryController extends Controller
{
    public function index()
    {
        $items = Gallery::with('images')->latest()->paginate(12);
        return view('admin.gallery.index', compact('items'));
    }

    public function create()
    {
        return view('admin.gallery.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'images' => 'required|array|min:1',
            'images.*' => 'image|max:6144',
            'status' => 'nullable|in:published,draft',
        ]);

        $gallery = Gallery::create([
            'title' => $data['title'],
            'status' => $request->input('status','published'),
        ]);

        foreach (($request->file('images') ?? []) as $idx => $file) {
            $path = $file->store('gallery', 'public');
            GalleryImage::create([
                'gallery_id' => $gallery->id,
                'image_path' => $path,
                'sort_order' => $idx,
            ]);
        }

        return redirect()->route('admin.gallery.index')->with('success','Galeri ditambahkan');
    }

    public function edit(Gallery $gallery)
    {
        $gallery->load('images');
        return view('admin.gallery.edit', compact('gallery'));
    }

    public function update(Request $request, Gallery $gallery)
    {
        $data = $request->validate([
            'title' => 'required|string|max:255',
            'new_images' => 'nullable|array',
            'new_images.*' => 'image|max:6144',
            'status' => 'nullable|in:published,draft',
            'delete_image_ids' => 'nullable|array',
            'delete_image_ids.*' => 'integer',
        ]);

        // delete selected images
        $deleteIds = collect($request->input('delete_image_ids', []))->filter();
        if ($deleteIds->isNotEmpty()) {
            $images = GalleryImage::whereIn('id', $deleteIds)->where('gallery_id',$gallery->id)->get();
            foreach ($images as $img) {
                Storage::disk('public')->delete($img->image_path);
                $img->delete();
            }
        }

        // add new images
        if ($request->hasFile('new_images')) {
            $start = (int) ($gallery->images()->max('sort_order') ?? 0) + 1;
            foreach ($request->file('new_images') as $i => $file) {
                $path = $file->store('gallery', 'public');
                GalleryImage::create([
                    'gallery_id' => $gallery->id,
                    'image_path' => $path,
                    'sort_order' => $start + $i,
                ]);
            }
        }

        $gallery->title = $data['title'];
        $gallery->status = $request->input('status','published');
        $gallery->save();

        return redirect()->route('admin.gallery.index')->with('success','Galeri diperbarui');
    }

    public function destroy(Gallery $gallery)
    {
        if ($gallery->image_path) Storage::disk('public')->delete($gallery->image_path);
        $gallery->delete();
        return back()->with('success','Galeri dihapus');
    }
}