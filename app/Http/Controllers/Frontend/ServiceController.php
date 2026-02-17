<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Service;
use App\Models\ServiceCategory;

class ServiceController extends Controller
{
    public function index()
    {
        $categories = ServiceCategory::with(['services' => function($q){
            $q->where('status','active');
        }])->get();
        return view('frontend.service.index', compact('categories'));
    }

    public function show(string $slug)
    {
        $service = Service::where('slug',$slug)->where('status','active')->firstOrFail();
        return view('frontend.service.show', compact('service'));
    }
}