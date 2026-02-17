<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Agenda;
use Illuminate\Http\Request;
use Carbon\Carbon;

class AgendaController extends Controller
{
    public function index()
    {
        $items = Agenda::latest('start_date')->paginate(12);
        return view('admin.agenda.index', compact('items'));
    }

    // TinyMCE image upload endpoint for Program description
    public function uploadImage(Request $request)
    {
        $request->validate([
            'file' => 'required|image|max:4096',
        ]);
        $path = $request->file('file')->store('agenda-images', 'public');
        return response()->json(['location' => \Storage::url($path)]);
    }

    public function create()
    {
        return view('admin.agenda.create');
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'start_date' => 'required|string', // from datetime-local
            'end_date' => 'nullable|string', // from datetime-local
            'location' => 'nullable|string|max:200',
            'status' => 'required|in:draft,published',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);
        // normalize datetime
        $data['start_date'] = Carbon::parse($data['start_date']);
        $data['end_date'] = !empty($data['end_date']) ? Carbon::parse($data['end_date']) : null;

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')->store('agenda', 'public');
        }

        Agenda::create($data);
        return redirect()->route('admin.agenda.index')->with('success', 'Agenda dibuat');
    }

    public function edit(Agenda $agendum)
    {
        return view('admin.agenda.edit', ['agenda' => $agendum]);
    }

    public function update(Request $request, Agenda $agendum)
    {
        $data = $request->validate([
            'title' => 'required|string|max:200',
            'description' => 'nullable|string',
            'start_date' => 'required|string', // from datetime-local
            'end_date' => 'nullable|string', // from datetime-local
            'location' => 'nullable|string|max:200',
            'status' => 'required|in:draft,published',
            'attachment' => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);
        // normalize datetime
        $data['start_date'] = Carbon::parse($data['start_date']);
        $data['end_date'] = !empty($data['end_date']) ? Carbon::parse($data['end_date']) : null;

        if ($request->hasFile('attachment')) {
            // optional: delete old file
            if ($agendum->attachment && \Storage::disk('public')->exists($agendum->attachment)) {
                \Storage::disk('public')->delete($agendum->attachment);
            }
            $data['attachment'] = $request->file('attachment')->store('agenda', 'public');
        }

        $agendum->update($data);
        return redirect()->route('admin.agenda.index')->with('success', 'Agenda diperbarui');
    }

    public function destroy(Agenda $agendum)
    {
        if ($agendum->attachment && \Storage::disk('public')->exists($agendum->attachment)) {
            \Storage::disk('public')->delete($agendum->attachment);
        }
        $agendum->delete();
        return back()->with('success', 'Agenda dihapus');
    }
}