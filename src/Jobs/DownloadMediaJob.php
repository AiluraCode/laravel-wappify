<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Jobs;

use AiluraCode\Wappify\Contracts\Messages\ShouldMultimediaMessage;
use AiluraCode\Wappify\Contracts\ShouldMessage;
use AiluraCode\Wappify\Exceptions\CastToMediaException;
use AiluraCode\Wappify\Exceptions\PropertyNoExists;
use AiluraCode\Wappify\Models\Whatsapp;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Config;
use Throwable;

use function Laravel\Prompts\error;

final class DownloadMediaJob implements ShouldQueue
{
    use Dispatchable;
    use InteractsWithQueue;
    use Queueable;
    use SerializesModels;

    private string $extension;
    private ShouldMultimediaMessage $media;

    /**
     * @param Whatsapp    $whatsapp   The whatsapp message
     * @param string      $collection The collection name
     * @param string|null $name       The name of the media
     *
     * @throws CastToMediaException|PropertyNoExists
     */
    public function __construct(
        private readonly ShouldMessage $whatsapp,
        private string $collection = 'default',
        private ?string $name = null,
    ) {
        // @phpstan-ignore-next-line
        $this->collection = Config::get('wappify.spatie.collection');
        if (is_null($this->name)) {
            $this->name = $this->formatWamId();
        }
        $this->media = $this->whatsapp->toMedia();
        $this->extension = $this->getExtension();
    }

    public function handle(): void
    {
        try {
            $fullName = $this->name . '.' . $this->extension;
            $response = whatsapp()->downloadMedia($this->media->getId());
            $this->whatsapp->addMediaFromStream($response->body())
                ->usingFileName($fullName)
                ->toMediaCollection($this->collection);
        } catch (Throwable $th) {
            error($th->getMessage());
        }
    }

    /**
     * Remove "wamid." and "=" from wamid.
     *
     * @return string
     */
    private function formatWamId(): string
    {
        return rtrim(ltrim($this->whatsapp->getWamId(), 'wamid.'), '=');
    }

    /**
     * Get the extension of the media from a mime type.
     *
     * @return string
     */
    private function getExtension(): string
    {
        return explode('/', $this->media->getMimeType())[1];
    }
}
