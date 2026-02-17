<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Carbon\Carbon;

class BeritaController extends Controller
{
    public function index()
    {
        $items = Berita::latest()->paginate(12);
        return view('admin.berita.index', compact('items'));
    }

    public function create()
    {
        return view('admin.berita.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|string', // from datetime-local
        ]);

        $data['slug'] = Str::slug($data['title']);
        $data['author_id'] = auth()->id();
        if (!empty($data['published_at'])) {
            $data['published_at'] = Carbon::parse($data['published_at']);
        } else {
            $data['published_at'] = null;
        }
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        Berita::create($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita berhasil dibuat');
    }

    public function edit(Berita $berita)
    {
        return view('admin.berita.edit', compact('berita'));
    }

    public function update(Request $request, Berita $berita)
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'excerpt' => 'nullable|string',
            'content' => 'required|string',
            'thumbnail' => 'nullable|image|max:2048',
            'status' => 'required|in:draft,published',
            'published_at' => 'nullable|string', // from datetime-local
        ]);

        $data['slug'] = Str::slug($data['title']);
        if (!empty($data['published_at'])) {
            $data['published_at'] = Carbon::parse($data['published_at']);
        } else {
            $data['published_at'] = null;
        }
        if ($request->hasFile('thumbnail')) {
            $data['thumbnail'] = $request->file('thumbnail')->store('thumbnails', 'public');
        }

        $berita->update($data);
        return redirect()->route('admin.berita.index')->with('success', 'Berita diperbarui');
    }

    public function destroy(Berita $berita)
    {
        $berita->delete();
        return back()->with('success', 'Berita dihapus');
    }

    // TinyMCE image upload endpoint
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:4096',
        ]);
        $path = $request->file('file')->store('berita-images', 'public');
        return response()->json(['location' => Storage::url($path)]);
    }
}