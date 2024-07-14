<?php

namespace AiluraCode\Wappify\Jobs;

use AiluraCode\Wappify\Wappify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Netflie\WhatsAppCloudApi\Response\ResponseException;

class SendTextMessageJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $from, private string $text, private $account = 'default')
    {
    }

    /**
     * Execute the job.
     *
     * @throws ResponseException
     */
    public function handle(): void
    {
        $response = whatsapp($this->account)->sendTextMessage(
            $this->from,
            $this->text
        );
        Wappify::raise($response)->get()->save();
    }
}
