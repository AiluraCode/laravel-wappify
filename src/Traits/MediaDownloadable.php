<?php

namespace AiluraCode\Wappify\Traits;

use GuzzleHttp\Client;
use GuzzleHttp\Promise\PromiseInterface;
use GuzzleHttp\Psr7\Request;
use Illuminate\Support\Facades\Storage;
use Psr\Http\Message\StreamInterface;

trait MediaDownloadable
{

    public function getContentAsync(): PromiseInterface
    {
        if (!$this->id) {
            throw new \Exception('Media ID is required');
        }
        $media_id = $this->id;
        $token = config('wappify.token');
        $version = config('wappify.version');
        $url = "https://graph.facebook.com/{$version}/{$media_id}/";
        $headers = ['Authorization' => "Bearer {$token}"];
        $client = new Client();
        $request = new Request('GET', $url, $headers);
        return $client->sendAsync($request)->then(
            function ($response) use ($headers): PromiseInterface {
                $url = json_decode($response->getBody()->getContents(), true)['url'];
                $client = new Client();
                $request = new Request('GET', $url, $headers);
                return $client->sendAsync($request)->then(fn ($response) => $response->getBody());
            }
        );
    }

    public function getContent()
    {
        return $this->getContentAsync()->wait();
    }

    public function saveMediaAsync(string $path = null, string $name = null): PromiseInterface
    {
        return $this->getContentAsync()->then(
            function (StreamInterface $stream) use ($name, $path): string {
                $name = $name ?? uniqid();
                $path = $path ?? config('wappify.download_path');
                $ext = $this->getExtension();
                $path = "{$path}/{$ext}/{$name}.{$ext}";
                Storage::put($path, $stream->getContents());
                return $path;
            }
        );
    }

    public function saveMedia(string $path = null, string $name = null)
    {
        return $this->saveMediaAsync($name, $path)->wait();
    }

    public function getExtension(): string
    {
        return explode('/', $this->mime_type)[1];
    }

    public function getType(): string
    {
        return explode('/', $this->mime_type)[0];
    }
}
