<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Berita;
use Illuminate\Http\Request;

class BeritaController extends Controller
{
    public function index()
    {
        $beritas = Berita::where('status','published')->latest('published_at')->paginate(9);
        return view('frontend.berita.index', compact('beritas'));
    }

    public function show(string $slug)
    {
        $berita = Berita::where('slug',$slug)->where('status','published')->firstOrFail();
        $others = Berita::where('status','published')
            ->where('id','!=',$berita->id)
            ->latest('published_at')
            ->limit(8)
            ->get();
        return view('frontend.berita.show', compact('berita','others'));
    }
}