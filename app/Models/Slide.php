<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Slide extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'caption',
        'image_path',
        'status', // draft|published
        'sort_order',
        'interval_ms', // optional per-slide interval
    ];
}