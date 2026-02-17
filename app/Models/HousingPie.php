<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousingPie extends Model
{
    use HasFactory;

    protected $fillable = [
        'livable',    // Rumah Layak Huni (count or percent)
        'unlivable',  // Rumah Tidak Layak Huni (count or percent)
    ];

    // Cast to float to support decimals in admin inputs
    protected $casts = [
        'livable' => 'float',
        'unlivable' => 'float',
    ];
}