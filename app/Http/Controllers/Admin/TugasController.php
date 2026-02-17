<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tugas;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class TugasController extends Controller
{
    public function index()
    {
        $items = Tugas::latest()->paginate(15);
        return view('admin.tugas.index', compact('items'));
    }

    public function create()
    {
        return view('admin.tugas.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'pdf' => 'nullable|file|mimes:pdf|max:10240', // 10MB
        ]);
        $payload = [
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ];
        if ($request->hasFile('pdf')) {
            $payload['pdf_path'] = $request->file('pdf')->store('files/tugas', 'public');
        }
        Tugas::create($payload);
        return redirect()->route('admin.tugas.index')->with('success', 'Tugas & Fungsi dibuat');
    }

    public function edit(Tugas $tuga) // route-model key default matches "tugas" → parameter name becomes $tuga
    {
        return view('admin.tugas.edit', ['tugas' => $tuga]);
    }

    public function update(Request $request, Tugas $tuga)
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'pdf' => 'nullable|file|mimes:pdf|max:10240',
        ]);
        $payload = [
            'title' => $data['title'],
            'description' => $data['description'] ?? null,
        ];
        if ($request->hasFile('pdf')) {
            if ($tuga->pdf_path) {
                Storage::disk('public')->delete($tuga->pdf_path);
            }
            $payload['pdf_path'] = $request->file('pdf')->store('files/tugas', 'public');
        }
        $tuga->update($payload);
        return redirect()->route('admin.tugas.index')->with('success', 'Tugas & Fungsi diperbarui');
    }

    public function destroy(Tugas $tuga)
    {
        if ($tuga->pdf_path) {
            Storage::disk('public')->delete($tuga->pdf_path);
        }
        $tuga->delete();
        return back()->with('success', 'Tugas & Fungsi dihapus');
    }
}