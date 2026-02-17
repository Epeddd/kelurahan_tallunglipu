<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use App\Models\Agenda;
use App\Models\Resident;
use Illuminate\Support\Facades\Schema;

class HomeController extends Controller
{
    public function index()
    {
        $beritas = Berita::where('status','published')->latest('published_at')->limit(5)->get();
        $agendas = Agenda::where('status','published')->orderBy('start_date','asc')->limit(5)->get();

        // Carousel slides
        $slides = collect();
        if (Schema::hasTable('slides')) {
            $slides = \App\Models\Slide::where('status','published')->orderBy('sort_order')->get();
        }
        $carouselInterval = 6000;

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

        return view('frontend.home', compact(
            'beritas', 'agendas', 'slides', 'carouselInterval',
            'residentBars', 'residentPie'
        ));
    }
}