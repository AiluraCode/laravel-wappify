<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Jobs;

use AiluraCode\Wappify\Models\Whatsapp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

final class UpdateStatusMessageJob implements ShouldQueue
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
        dd('here');
        $whatsapp_related = Whatsapp::getMessageRelated($this->whatsapp);
        if ($whatsapp_related->getStatus()->isRead()) {
            exit;
        }
        $message = $whatsapp_related->getMessage();
        // @phpstan-ignore-next-line
        $message->status = $this->whatsapp->getMessage()->status;
        $whatsapp_related->message = $message;
        $whatsapp_related->save();
    }
}
