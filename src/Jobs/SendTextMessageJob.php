<?php

namespace AiluraCode\Wappify\Jobs;

use AiluraCode\Wappify\Wappify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class SendTextMessageJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $from, private string $text)
    {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        $response = whatsapp()->sendTextMessage(
            $this->from,
            $this->text
        );
        Wappify::raise($response)->get()->save();
    }
}
