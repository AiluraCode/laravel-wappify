<?php

namespace AiluraCode\Wappify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappMediaSticker extends Model
{

    protected $table = 'whatsapp_media';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'mime_type',
        'sha256',
        'whatsapp_id',
        'id',
    ];

    protected $appends = [
        'animated'
    ];

    protected $hidden = [
        'data'
    ];

    protected $casts = [
        'data' => 'array',
        'animated' => 'boolean'
    ];

    public function getAnimatedAttribute()
    {
        return $this->data['animated'];
    }

    public function setAnimatedAttribute(bool $value)
    {
        $this->data = [
            'animated' => $value
        ];
    }

    public function whatsapp(): BelongsTo
    {
        return $this->belongsTo(Whatsapp::class);
    }
}
