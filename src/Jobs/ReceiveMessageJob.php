<?php

namespace AiluraCode\Wappify\Jobs;

use AiluraCode\Wappify\Models\Whatsapp;
use AiluraCode\Wappify\Wappify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Throwable;

final class ReceiveMessageJob implements ShouldQueue
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
            if ($whatsapp->isStatus()) {
                // @phpstan-ignore-next-line
                $whatsapp_old = Whatsapp::findByWamid($whatsapp->getWamId());
                if ($whatsapp_old->exists()) {
                    /** @var Whatsapp $whatsapp_old */
                    if ($whatsapp_old->getStatus()->isRead()) {
                        return;
                    }
                    $message = $whatsapp_old->getMessage();
                    // @phpstan-ignore-next-line
                    $message->status = $whatsapp->getMessage()->status;
                    $whatsapp_old->message = $message;
                    $whatsapp_old->save();
                }
            } else {
                $whatsapp->save();
                whatsapp()->markMessageAsRead($whatsapp->getWamId());
                $canDownload = Config::get('wappify.download.automatic');
                if (!$canDownload) {
                    return;
                }
                if ($whatsapp->getType()->isDownloadable()) {
                    DownloadMediaJob::dispatch($whatsapp)
                        // @phpstan-ignore-next-line
                        ->onQueue(Config::get('wappify.queue.name'))
                    ;
                }
            }
        } catch (Throwable $th) {
            dd($th->getMessage());
        }
    }
}
