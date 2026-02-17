<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Gallery extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'status', // published|draft
    ];

    public function images()
    {
        return $this->hasMany(GalleryImage::class)->orderBy('sort_order');
    }
}