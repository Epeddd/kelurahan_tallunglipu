<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use Illuminate\Http\Request;

class InfografisController extends Controller
{
    public function index()
    {
        // Resident stats for Bar chart
        $residentBars = [
            ['label' => 'Jumlah Penduduk', 'value' => Resident::count()],
            ['label' => "Bo'ne Limbong", 'value' => Resident::where('wilayah', "Bo'ne Limbong")->count()],
            ['label' => "Bo'ne Matampu' Selatan", 'value' => Resident::where('wilayah', "Bo'ne Matampu' Selatan")->count()],
            ['label' => "Bo'ne Matampu' Utara", 'value' => Resident::where('wilayah', "Bo'ne Matampu' Utara")->count()],
            ['label' => "Bo'ne Randanan", 'value' => Resident::where('wilayah', "Bo'ne Randanan")->count()],
        ];

        // Resident stats for Pie chart
        $residentPie = [
            'tallunglipu' => Resident::where('status', 'Tallunglipu')->count(),
            'non_permanent' => Resident::where('status', 'Non-Permanent')->count()
        ];

        return view('pju.index', compact('residentBars', 'residentPie'));
    }
}
