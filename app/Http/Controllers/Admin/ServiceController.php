<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Storage;

class ServiceController extends Controller
{
    public function index()
    {
        $items = Service::with('category')->latest()->paginate(15);
        return view('admin.services.index', compact('items'));
    }

    public function create()
    {
        $categories = ServiceCategory::orderBy('name')->get();
        return view('admin.services.create', compact('categories'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'requirements' => 'nullable', // will parse JSON string from hidden input
            'external_link' => 'nullable|url',
            'has_submission' => 'required|boolean',
            'requirements_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'status' => 'required|in:inactive,active',
        ]);
        $data['slug'] = Str::slug($data['title']);
        // normalize requirements to array
        if (isset($data['requirements']) && is_string($data['requirements'])) {
            $decoded = json_decode($data['requirements'], true);
            $data['requirements'] = is_array($decoded) ? $decoded : [];
        }
        if ($request->hasFile('requirements_pdf')) {
            $data['requirements_pdf'] = $request->file('requirements_pdf')->store('files/services', 'public');
        }
        // Normalize has_submission checkbox
        $data['has_submission'] = (bool)($data['has_submission'] ?? true);
        Service::create($data);
        return redirect()->route('admin.services.index')->with('success','Layanan dibuat');
    }

    public function edit(Service $service)
    {
        $categories = ServiceCategory::orderBy('name')->get();
        return view('admin.services.edit', compact('service','categories'));
    }

    public function update(Request $request, Service $service)
    {
        $data = $request->validate([
            'category_id' => 'required|exists:service_categories,id',
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'requirements' => 'nullable', // will parse JSON string from hidden input
            'external_link' => 'nullable|url',
            'has_submission' => 'required|boolean',
            'requirements_pdf' => 'nullable|file|mimes:pdf|max:5120',
            'status' => 'required|in:inactive,active',
        ]);
        $data['slug'] = Str::slug($data['title']);
        // normalize requirements to array
        if (isset($data['requirements']) && is_string($data['requirements'])) {
            $decoded = json_decode($data['requirements'], true);
            $data['requirements'] = is_array($decoded) ? $decoded : [];
        }
        if ($request->hasFile('requirements_pdf')) {
            // delete old if exists
            if ($service->requirements_pdf) {
                Storage::disk('public')->delete($service->requirements_pdf);
            }
            $data['requirements_pdf'] = $request->file('requirements_pdf')->store('files/services', 'public');
        }
        // Normalize has_submission checkbox
        $data['has_submission'] = (bool)($data['has_submission'] ?? true);
        $service->update($data);
        return redirect()->route('admin.services.index')->with('success','Layanan diperbarui');
    }

    public function destroy(Service $service)
    {
        $service->delete();
        return back()->with('success','Layanan dihapus');
    }
}