<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Resident;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'berita' => Berita::count(),
            'penduduk' => Resident::count(),
        ];

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

        return view('admin.dashboard', compact('stats', 'residentBars', 'residentPie'));
    }
}