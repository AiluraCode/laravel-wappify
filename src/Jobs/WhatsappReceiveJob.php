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

    public function __construct()
    {
        $payload = file_get_contents('php://input');
        $this->wappify = new Wappify();
        $this->wappify->catch($payload);
        try {
            if (!$this->wappify->whatsapp) {
                http_response_code(404);
            }
        } catch (\Throwable $th) {
            http_response_code(409);
        }
    }

    public function handle(): void
    {
        exit;
    }
}
