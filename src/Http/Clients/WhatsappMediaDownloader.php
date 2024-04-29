<?php

namespace AiluraCode\Wappify\Http\Clients;

use AiluraCode\Wappify\Models\Whatsapp;
use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Storage;

class WhatsappMediaDownloader
{
    private static function buildUrl(string $id): string
    {
        $version = config('wappify.version');
        return "https://graph.facebook.com/{$version}/{$id}/";
    }

    public static function getUrlAsync(Whatsapp $whatsapp): PromiseInterface
    {
        if (!$whatsapp->type->isDownloadable()) {
            throw new \Exception('Message is not a media.');
        }
        $url = self::buildUrl($whatsapp->message["id"]);
        $client = new Client();
        $request = new Request('GET', $url,
    );
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
        $request = new Request('GET', self::getUrl($whatsapp), config('wappify.headers'));
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
                $path = $path ?? config('wappify.download_path');
                $ext = self::getExtension($whatsapp->message['mime_type']);
                $path = "{$path}/{$ext}/{$name}.{$ext}";
                Storage::put($path, $stream->getContents());
                return $path;
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
}
