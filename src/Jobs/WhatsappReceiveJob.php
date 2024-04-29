<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Jobs;

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

    private Wappify $wappify;
    private string|false $payload;
    private bool $save;

    public function __construct(string|false $payload, bool $save = false)
    {
        $this->payload = $payload;
        $this->save = $save;
    }

    public function handle(): void
    {
        $this->wappify = new Wappify();
        $this->wappify->catch($this->payload);
        try {
            if (!$this->wappify->whatsapp) {
                return;
            }
            if ($this->save) {
                $this->wappify->whatsapp->save();
                if (!$this->wappify->whatsapp->type->isDownloadable())
                    return;
                WhatsappGetURLMedia::dispatch($this->wappify->whatsapp)
                    ->onQueue(config('wappify.queue_url'));
            }
        } catch (\Throwable $th) {
            $this->fail($th);
        }
    }
}
