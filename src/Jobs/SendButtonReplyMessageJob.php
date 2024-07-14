<?php

namespace AiluraCode\Wappify\Jobs;

use AiluraCode\Wappify\Wappify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Netflie\WhatsAppCloudApi\Message\ButtonReply\ButtonAction;

class SendButtonReplyMessageJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     *
     * @param string              $from
     * @param string              $message
     * @param array<ButtonAction> $buttons
     */
    public function __construct(
        private readonly string $from,
        private readonly string $message,
        private readonly array $buttons,
        private $account = 'default'
    ) {
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        try {
            $action = new ButtonAction($this->buttons);
            $response = whatsapp($this->account)->sendButton(
                $this->from,
                $this->message,
                $action
            );
            Wappify::raise($response)->get()->save();
        } catch (\Throwable $th) {
            dd($th->getMessage());
        }
    }
}
