<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Jobs;

use AiluraCode\Wappify\Enums\MessageType;
use AiluraCode\Wappify\Models\Whatsapp;
use AiluraCode\Wappify\Wappify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class WhatsappReceiveMessageJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private string|false $payload;

    public function __construct(string|false $payload)
    {
        $this->payload = $payload;
    }

    public function handle(): void
    {
        try {
            $whatsapp = Wappify::catch($this->payload)->get();
            if (!$whatsapp) {
                return;
            }
            if (Whatsapp::where('wamid', $whatsapp->wamid)->exists()) {
                if ($whatsapp->type === MessageType::STATUS) {
                    $aux = Whatsapp::findByWamid($whatsapp->wamid);
                    if (!$aux) {
                        exit();
                        return;
                    }
                    $status = $aux->message->status ?? null;
                    if ($status == 'read') {
                        exit();
                        return;
                    }
                    $message = $aux->message;
                    $message->status = $whatsapp->message->status;
                    $aux->message = $message;
                    $aux->save();
                }
                return;
            }
            $whatsapp->save();
            if (config('wappify.download.automatic') && $whatsapp->type->isDownloadable()) {
                WhatsappDownloadMediaJob::dispatch($whatsapp)
                    ->onQueue(config('wappify.queue.name'));
            }
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
