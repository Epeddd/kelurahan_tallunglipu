<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\HousingStat;
use App\Models\HousingNote;
use App\Models\HousingPie;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Cache;

class HousingStatController extends Controller
{
    public function index()
    {
        $stats = HousingStat::orderBy('sort_order')->get();
        $note = HousingNote::first();
        $pie = HousingPie::first();
        return view('admin.housing_stats.index', compact('stats','note','pie'));
    }

    public function store(Request $request)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255|unique:housing_stats,label',
            'value' => 'required|integer|min:0',
            'sort_order' => 'nullable|integer|min:0'
        ]);
        HousingStat::create($data);
        // Invalidate caches so frontend/dashboard see updates immediately
        Cache::forget('housing_stats_home');
        Cache::forget('housing_note_home');
        Cache::forget('housing_pie_home');
        return back()->with('success','Data ditambahkan');
    }

    public function update(Request $request, HousingStat $housing_stat)
    {
        $data = $request->validate([
            'label' => 'required|string|max:255|unique:housing_stats,label,'.$housing_stat->id,
            'value' => 'required|integer|min:0',
            'sort_order' => 'nullable|integer|min:0'
        ]);
        $housing_stat->update($data);
        Cache::forget('housing_stats_home');
        Cache::forget('housing_note_home');
        Cache::forget('housing_pie_home');
        return back()->with('success','Data diperbarui');
    }

    public function destroy(HousingStat $housing_stat)
    {
        $housing_stat->delete();
        Cache::forget('housing_stats_home');
        Cache::forget('housing_note_home');
        Cache::forget('housing_pie_home');
        return back()->with('success','Data dihapus');
    }

    public function updateNote(Request $request)
    {
        $data = $request->validate([
            'content' => 'nullable|string'
        ]);
        $note = HousingNote::first();
        if (!$note) { $note = new HousingNote(); }
        $note->content = $data['content'] ?? null;
        $note->save();
        Cache::forget('housing_note_home');
        Cache::forget('housing_pie_home');
        return back()->with('success','Catatan diperbarui');
    }

    public function updatePie(Request $request)
    {
        $data = $request->validate([
            'livable' => 'required|numeric|min:0',
            'unlivable' => 'required|numeric|min:0',
        ]);
        $pie = HousingPie::first();
        if (!$pie) { $pie = new HousingPie(); }
        $pie->livable = (float) $data['livable'];
        $pie->unlivable = (float) $data['unlivable'];
        $pie->save();
        Cache::forget('housing_pie_home');
        return back()->with('success','Data diagram lingkaran diperbarui');
    }
}