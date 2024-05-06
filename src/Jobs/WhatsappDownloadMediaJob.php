<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Jobs;

use AiluraCode\Wappify\Http\Clients\WhatsappClientDownloader;
use AiluraCode\Wappify\Models\Whatsapp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

use function Laravel\Prompts\error;

final class WhatsappDownloadMediaJob  implements ShouldQueue
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
        if ($this->whatsapp->type->isDownloadable()) {
            try {
                WhatsappClientDownloader::download($this->whatsapp);
            } catch (\Throwable $th) {
                error($th->getMessage());
            }
        }
    }
}
