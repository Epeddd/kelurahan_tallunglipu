<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ServiceCategoryController extends Controller
{
    public function index()
    {
        $items = ServiceCategory::latest()->paginate(15);
        return view('admin.service_categories.index', compact('items'));
    }

    public function create()
    {
        return view('admin.service_categories.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
        ]);
        $data['slug'] = Str::slug($data['name']);
        ServiceCategory::create($data);
        return redirect()->route('admin.service-categories.index')->with('success','Kategori dibuat');
    }

    public function edit(ServiceCategory $service_category)
    {
        return view('admin.service_categories.edit', ['category' => $service_category]);
    }

    public function update(Request $request, ServiceCategory $service_category)
    {
        $data = $request->validate([
            'name' => 'required|string|max:150',
        ]);
        $data['slug'] = Str::slug($data['name']);
        $service_category->update($data);
        return redirect()->route('admin.service-categories.index')->with('success','Kategori diperbarui');
    }

    public function destroy(ServiceCategory $service_category)
    {
        $service_category->delete();
        return back()->with('success','Kategori dihapus');
    }
}