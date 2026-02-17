<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Gallery;

class GalleryController extends Controller
{
    public function index()
    {
        $items = Gallery::with('images')->where('status','published')->latest()->paginate(12);
        return view('frontend.gallery.index', compact('items'));
    }
}