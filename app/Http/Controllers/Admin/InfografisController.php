<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use Illuminate\Http\Request;

class InfografisController extends Controller
{
    public function index(Request $request)
    {
        $search = $request->get('search');
        $query = Resident::query();

        if ($search) {
            $query->where(function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('nik', 'like', "%{$search}%")
                  ->orWhere('no_kk', 'like', "%{$search}%");
            });
        }

        $data = $query->latest()->get();

        // Resident stats for Bar chart
        $residentBars = [
            ['label' => 'Jumlah Penduduk', 'value' => Resident::count()],
            ['label' => "Bo'ne Limbong", 'value' => Resident::where('wilayah', "Bo'ne Limbong")->count()],
            ['label' => "Bo'ne Matampu' Selatan", 'value' => Resident::where('wilayah', "Bo'ne Matampu' Selatan")->count()],
            ['label' => "Bo'ne Matampu' Utara", 'value' => Resident::where('wilayah', "Bo'ne Matampu' Utara")->count()],
            ['label' => "Bo'ne Randanan", 'value' => Resident::where('wilayah', "Bo'ne Randanan")->count()],
        ];

        // Resident stats for Pie chart (Status)
        $tallunglipuCount = Resident::where('status', 'Tallunglipu')->count();
        $nonPermanentCount = Resident::where('status', 'Non-Permanent')->count();
        
        $residentPie = [
            'tallunglipu' => $tallunglipuCount,
            'non_permanent' => $nonPermanentCount
        ];

        return view('admin.infografis.index', compact('data', 'residentBars', 'residentPie'));
    }

    public function create()
    {
        return view('admin.infografis.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:20|unique:residents',
            'no_kk' => 'required|string|max:20',
            'wilayah' => 'required|string',
            'status' => 'required|in:Tallunglipu,Non-Permanent',
        ]);

        Resident::create($request->all());

        return redirect()->route('admin.infografis.index')->with('success', 'Penduduk berhasil ditambahkan');
    }

    public function edit($id)
    {
        $resident = Resident::findOrFail($id);
        return view('admin.infografis.edit', compact('resident'));
    }

    public function update(Request $request, $id)
    {
        $resident = Resident::findOrFail($id);
        $request->validate([
            'name' => 'required|string|max:255',
            'nik' => 'required|string|max:20|unique:residents,nik,' . $resident->id,
            'no_kk' => 'required|string|max:20',
            'wilayah' => 'required|string',
            'status' => 'required|in:Tallunglipu,Non-Permanent',
        ]);

        $resident->update($request->all());

        return redirect()->route('admin.infografis.index')->with('success', 'Data penduduk berhasil diupdate');
    }

    public function destroy($id)
    {
        $resident = Resident::findOrFail($id);
        $resident->delete();
        return redirect()->route('admin.infografis.index')->with('success', 'Data penduduk berhasil dihapus');
    }
}
