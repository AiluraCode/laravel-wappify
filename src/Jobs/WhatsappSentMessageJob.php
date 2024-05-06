<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Jobs;

use AiluraCode\Wappify\Wappify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Netflie\WhatsAppCloudApi\Response;

final class WhatsappReceiveMessageJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private Response $response;

    public function __construct(Response $response)
    {
        $this->response = $response;
    }

    public function handle(): void
    {
        try {
            $whatsapp = Wappify::raise($this->response)->get();
            $whatsapp->save();
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
