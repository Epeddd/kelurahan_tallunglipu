<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Service extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'title',
        'slug',
        'description',
        'requirements',
        'external_link',
        'has_submission',
        'requirements_pdf',
        'status',
    ];

    protected $casts = [
        'requirements' => 'array',
        'has_submission' => 'boolean',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(ServiceCategory::class, 'category_id');
    }

    public function requests(): HasMany
    {
        return $this->hasMany(ServiceRequest::class);
    }
}