<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Jobs;

use AiluraCode\Wappify\Http\Clients\WhatsappMediaDownloader;
use AiluraCode\Wappify\Models\Whatsapp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class WhatsappGetURLMedia implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private Whatsapp $whatsapp;

    public function __construct(Whatsapp $whatsapp)
    {
        $this->whatsapp = $whatsapp;
    }

    public function handle(): void
    {
        try {
            $client = new WhatsappMediaDownloader($this->whatsapp);
            $message = $this->whatsapp->message;
            $message['url'] = $client->getUrlAsync()->wait();
            $this->whatsapp->message = $message;
            $this->whatsapp->save();
        } catch (\Throwable $th) {
            $this->fail($th);
        }
    }
}
