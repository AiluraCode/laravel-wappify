<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Http\Controllers;

use AiluraCode\Wappify\Jobs\ReceiveMessageJob;
use AiluraCode\Wappify\Models\Whatsapp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Response;
use Netflie\WhatsAppCloudApi\WebHook;

final class WhatsappController extends Controller
{
    /**
     * Verify the webhook.
     */
    public function webhook(): void
    {
        $webhook = new WebHook();
        // @phpstan-ignore-next-line
        echo $webhook->verify($_GET, env('WHATSAPP_API_TOKEN_VERIFICATION'));
    }

    /**
     * Receive a Whatsapp message.
     */
    public function receive(): JsonResponse
    {
        $payload = file_get_contents('php://input');
        ReceiveMessageJob::dispatch($payload)
            // @phpstan-ignore-next-line
            ->onQueue(Config::get('wappify.queue.name'))
        ;

        // @phpstan-ignore-next-line
        return response()->json(['message' => 'Message received']);
    }

    /**
     * Get all Whatsapp messages.
     */
    public function index(): LengthAwarePaginator
    {
        // @phpstan-ignore-next-line
        return Whatsapp::paginate(25);
    }

    /**
     * show a Whatsapp message.
     *
     * @return JsonResponse
     */
    public function show(string $id): JsonResponse|Whatsapp
    {
        // @phpstan-ignore-next-line
        $whatsapp = Whatsapp::find($id);
        if (!$whatsapp) {
            return Response::json(['message' => 'Whatsapp not found'], 404);
        }

        return $whatsapp;
    }

    /**
     * Delete a Whatsapp message.
     */
    public function destroy(string $id, Request $request): JsonResponse
    {
        // @phpstan-ignore-next-line
        $withMedia = boolval($request->get('withMedia')) ?? false;
        // @phpstan-ignore-next-line
        $whatsapp = Whatsapp::find($id);
        if (!$whatsapp) {
            return Response::json(['message' => 'Whatsapp not found'], 404);
        }
        $whatsapp->delete();
        if ($withMedia) {
            $whatsapp->media->each(fn ($media) => $media->delete());

            return Response::json(['message' => 'Whatsapp deleted with media']);
        }

        return Response::json(['message' => 'Whatsapp deleted']);
    }

    /**
     * Stream media by Whatsapp id.
     */
    public function stream(string $id): JsonResponse
    {
        // @phpstan-ignore-next-line
        $whatsapp = Whatsapp::find($id);
        if (!$whatsapp) {
            return Response::json(['message' => 'Whatsapp not found'], 404);
        }
        if (!$whatsapp->type->isDownloadable()) {
            return Response::json(['message' => 'Message is not a media'], 400);
        }
        $url = $whatsapp->getMedia(config('wappify.spatie.collection'))->first()->getUrl();

        // @phpstan-ignore-next-line
        return response()->redirectTo($url);
    }

    /**
     * Download media by Whatsapp id.
     */
    public function download(string $id): JsonResponse
    {
        // @phpstan-ignore-next-line
        $whatsapp = Whatsapp::find($id);
        if (!$whatsapp) {
            return Response::json(['message' => 'Whatsapp not found'], 404);
        }
        if (!$whatsapp->type->isDownloadable()) {
            return Response::json(['message' => 'Message is not a media'], 400);
        }

        return $whatsapp->getMedia(config('wappify.spatie.collection'))->first();
    }

    /**
     * Get all messages in a specific chat.
     *
     * @return Whatsapp[]
     */
    public function chat(string $from): array
    {
        // @phpstan-ignore-next-line
        return Whatsapp::chat($from)->get();
    }

    /**
     * Get all messages from you.
     *
     * @return Whatsapp[]
     */
    public function me(): array
    {
        // @phpstan-ignore-next-line
        return Whatsapp::me()->get();
    }

    /**
     * Get all messages from you.
     *
     * @return Whatsapp[]
     */
    public function you(): array
    {
        // @phpstan-ignore-next-line
        return Whatsapp::you()->get();
    }

    /**
     * Get media by Whatsapp id.
     */
    public function media(string $id): JsonResponse
    {
        // @phpstan-ignore-next-line
        $whatsapp = Whatsapp::find($id);
        if ($whatsapp) {
            $collection = config('wappify.spatie.collection');
            if ($whatsapp->hasMedia($collection)) {
                return Response::json($whatsapp->getMedia($collection));
            }

            return Response::json(['message' => 'Whatsapp not found'], 404);
        }

        return Response::json(['message' => 'Whatsapp not found'], 404);
    }
}
