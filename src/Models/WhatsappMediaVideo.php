<?php

namespace AiluraCode\Wappify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappMediaVideo extends Model
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

    protected $hidden = [
        'data'
    ];

    public function whatsapp(): BelongsTo
    {
        return $this->belongsTo(Whatsapp::class);
    }
}
