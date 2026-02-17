<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class HousingStat extends Model
{
    use HasFactory;

    protected $fillable = [
        'label','value','sort_order'
    ];
}