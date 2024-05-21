<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Jobs;

use AiluraCode\Wappify\Http\Clients\WhatsappClient;
use AiluraCode\Wappify\Models\Whatsapp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Throwable;

use function Laravel\Prompts\error;

final class WhatsappDownloadMediaJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    public function __construct(private readonly Whatsapp $whatsapp)
    {
    }

    public function handle(): void
    {
        if ($this->whatsapp->getType()->isDownloadable()) {
            try {
                $media = $this->whatsapp->toMedia();
                $name = $this->whatsapp->getWamId();
                $extension = explode('/', $media->getMimeType())[1];
                $stream = WhatsappClient::getStreamAsync($this->whatsapp->toMedia());
                $this->whatsapp->addMediaFromStream($stream)
                    ->usingFileName("$name.$extension")
                    // @phpstan-ignore-next-line
                    ->toMediaCollection(Config::get('wappify.spatie.collection'));
            } catch (Throwable $th) {
                error($th->getMessage());
            }
        }
    }
}
