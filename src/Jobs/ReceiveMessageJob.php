<?php

namespace AiluraCode\Wappify\Jobs;

use AiluraCode\Wappify\Enums\MessageType;
use AiluraCode\Wappify\Models\Whatsapp;
use AiluraCode\Wappify\Wappify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;

final class WhatsappReceiveMessageJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private string $payload;

    public function __construct(string $payload)
    {
        $this->payload = $payload;
    }

    public function handle(): void
    {
        try {
            $whatsapp = Wappify::catch($this->payload)->get();
            // @phpstan-ignore-next-line
            $aux = Whatsapp::findByWamid($whatsapp->getWamId());
            if ($aux->exists()) {
                if (MessageType::STATUS === $whatsapp->getType()) {
                    $status = $aux->message->status ?? null;
                    if ('read' == $status) {
                        exit;
                    }
                    $message = $aux->message;
                    // @phpstan-ignore-next-line
                    $message->status = $whatsapp->message->status;
                    $aux->message = $message;
                    $aux->save();
                }

                return;
            }

            $whatsapp->save();
            if (Config::get('wappify.download.automatic') && $whatsapp->getType()->isDownloadable()) {
                WhatsappDownloadMediaJob::dispatch($whatsapp)
                    // @phpstan-ignore-next-line
                    ->onQueue(Config::get('wappify.queue.name'))
                ;
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
