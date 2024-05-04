<?php

namespace AiluraCode\Wappify\Http\Clients;

use AiluraCode\Wappify\Models\Whatsapp;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Storage;

class WhatsappClientDownloader
{
    private static function buildUrl(string $id): string
    {
        $url = config('wappify.api.url');
        $version = config('wappify.api.version');
        return "$url/{$version}/{$id}/";
    }

    public static function buildHeaders(): array
    {
        return [
            'Authorization' => "Bearer " . env('WHATSAPP_API_TOKEN')
        ];
    }

    public static function getUrlAsync(Whatsapp $whatsapp): PromiseInterface
    {
        if (!$whatsapp->type->isDownloadable()) {
            throw new \Exception('Message is not a media.');
        }
        $url = self::buildUrl($whatsapp->message["id"]);
        $client = new Client();
        $request = new Request('GET', $url, self::buildHeaders());
        return $client
            ->sendAsync($request)
            ->then(
                function ($response) use ($whatsapp): string {
                    $payload = json_decode($response->getBody()->getContents(), true);
                    $message = $whatsapp->message;
                    $message['url'] = $payload['url'];
                    $whatsapp->message = $message;
                    $whatsapp->save();
                    return $payload['url'];
                }
            );
    }

    public static function getUrl(Whatsapp $whatsapp)
    {
        return self::getUrlAsync($whatsapp)->wait();
    }

    public static function getContentAsync(Whatsapp $whatsapp): PromiseInterface
    {
        $client = new Client();
        $request = new Request('GET', self::getUrl($whatsapp), self::buildHeaders());
        return $client->sendAsync($request)
            ->then(fn ($response) => $response->getBody());
    }

    public static function getContent(Whatsapp $whatsapp)
    {
        return self::getContentAsync($whatsapp)->wait();
    }

    public static function downloadAsync(Whatsapp $whatsapp, string $path = null, string $name = null): PromiseInterface
    {
        return self::getContentAsync($whatsapp)->then(
            function ($stream) use ($whatsapp, $name, $path): string {
                $name = $name ?? str_replace("wamid.", "", $whatsapp->wa_id);
                $downloadStrategy = config('wappify.download.strategy');
                if ($downloadStrategy === 'default') {
                    return self::defaultDownloadStrrategy($whatsapp, $name, $stream, $path);
                }
                if ($downloadStrategy === 'spatie') {
                    return self::spatieDownloadStrategy($whatsapp, $name, $stream);
                }
            }
        );
    }

    public static function download(Whatsapp $whatsapp, string $path = null, string $name = null): string
    {
        return self::downloadAsync($whatsapp, $name)->wait();
    }

    private static function getExtension(string $mime_type): string
    {
        return explode('/', $mime_type)[1];
    }

    private static function defaultDownloadStrrategy(Whatsapp $whatsapp, string $name, mixed $stream, string $path = null): string
    {
        $path = $path ?? config('wappify.default.path');
        $ext = self::getExtension($whatsapp->message['mime_type']);
        $path = "{$path}/{$ext}/{$name}.{$ext}";
        Storage::put($path, $stream->getContents());
        return $path;
    }

    private static function spatieDownloadStrategy(Whatsapp $whatsapp, string $name, mixed $stream): string
    {
        return $whatsapp->addMediaFromStream($stream)
            ->usingFileName($name)
            ->toMediaCollection();
    }
}
