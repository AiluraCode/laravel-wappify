<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Jobs;

use AiluraCode\Wappify\Models\Whatsapp;
use AiluraCode\Wappify\Wappify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class WhatsappReceiveJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private Whatsapp $whatsapp;
    private string|false $payload;
    private bool $save;

    public function __construct(string|false $payload, bool $save = false)
    {
        $this->payload = $payload;
        $this->save = $save;
    }

    public function handle(): void
    {
        $this->whatsapp = Wappify::catch($this->payload)->get();
        $whatsapp = $this->whatsapp;
        if (!$whatsapp) {
            return;
        }
        if (Whatsapp::where('wamid', $whatsapp->wamid)->exists()) {
            $this->fail('Whatsapp already exists');
        }
        if (config('wappify.download.automatic')) {
            $whatsapp->save();
            $whatsapp->download();
        }
    }
}
