<?php

namespace AiluraCode\Wappify\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class WhatsappMessages extends Model
{

    protected $table = 'whatsapp_messages';
    public $timestamps = false;

    protected $fillable = [
        'text',
        'whatsapp_id'
    ];

    public function whatsapp(): BelongsTo
    {
        return $this->belongsTo(Whatsapp::class);
    }
}
