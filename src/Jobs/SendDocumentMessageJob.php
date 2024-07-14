<?php

namespace AiluraCode\Wappify\Jobs;

use AiluraCode\Wappify\Wappify;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Netflie\WhatsAppCloudApi\Message\Error\InvalidMessage;
use Netflie\WhatsAppCloudApi\Message\Media\LinkID;
use Netflie\WhatsAppCloudApi\Response\ResponseException;
use Spatie\MediaLibrary\MediaCollections\Models\Media;

class SendDocumentMessageJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    /**
     * Create a new job instance.
     */
    public function __construct(private string $from, private Media $document, private $account = 'default')
    {
    }

    /**
     * Execute the job.
     *
     * @throws ResponseException
     * @throws InvalidMessage
     */
    public function handle(): void
    {
        $document_link = $this->document->getUrl();
        $document_link = str_replace('http://cactu-pachanoi.test', 'https://united-hip-macaw.ngrok-free.app/cactu-pachanoi/public', $document_link);
        $document_name = $this->document->name;
        $document_caption = "Document: $document_name";
        $link_id = new LinkID($document_link);
        $response = whatsapp($this->account)->sendDocument(
            $this->from,
            $link_id,
            $document_name,
            $document_caption
        );
        Wappify::raise($response)->get()->save();
    }
}
