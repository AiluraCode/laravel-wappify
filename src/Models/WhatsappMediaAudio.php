<?php

namespace AiluraCode\Wappify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappMediaAudio extends Model
{

    protected $table = 'whatsapp_media';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'mime_type',
        'sha256',
        'whatsapp_id',
        'voice',
        'id',
    ];

    protected $hidden = [
        'data'
    ];

    protected $appends = [
        'voice',
    ];

    protected $casts = [
        'data' => 'array',
        'voice' => 'boolean',
    ];

    public function setVoiceAttribute($value)
    {
        $this->data = [
            'voice' => $value,
        ];
    }

    public function getVoiceAttribute(): bool
    {
        return $this->data['voice'];
    }

    public function whatsapp(): BelongsTo
    {
        return $this->belongsTo(Whatsapp::class);
    }
}
