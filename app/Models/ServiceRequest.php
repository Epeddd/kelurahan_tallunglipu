<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class ServiceRequest extends Model
{
    use HasFactory;

    protected $fillable = [
        'service_id',
        'applicant_name',
        'email',
        'phone',
        'message',
        'attachment_path', // legacy single file path (kept for backward-compat)
        // multiple attachments handled via relation
        'status',
    ];

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class);
    }

    public function attachments(): HasMany
    {
        return $this->hasMany(ServiceRequestAttachment::class);
    }
}