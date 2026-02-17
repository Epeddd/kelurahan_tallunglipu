<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Tugas;

class ProfileController extends Controller
{
    public function tugas()
    {
        $items = Tugas::latest()->get();
        return view('frontend.profil.tugas', compact('items'));
    }
}