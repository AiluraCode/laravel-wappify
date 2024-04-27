<?php

namespace AiluraCode\Wappify\Models;

use AiluraCode\Wappify\Traits\MediaDownloadable;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappMedia extends Model
{

    use MediaDownloadable;

    protected $table = 'whatsapp_media';
    public $timestamps = false;
    public $incrementing = false;

    protected $fillable = [
        'mime_type',
        'sha256',
        'data',
        'whatsapp_id',
        'id',
    ];

    public function whatsapp(): BelongsTo
    {
        return $this->belongsTo(Whatsapp::class);
    }
}
