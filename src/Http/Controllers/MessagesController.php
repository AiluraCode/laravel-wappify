<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Http\Controllers;

use AiluraCode\Wappify\Attributes\Controller as AiluraController;
use AiluraCode\Wappify\Attributes\Route as AiluraRoute;
use AiluraCode\Wappify\Models\Whatsapp;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Response;

#[AiluraController(name: 'messages', prefix: 'messages')]
final class MessagesController extends Controller
{
    /**
     * Get all Whatsapp messages.
     */
    #[AiluraRoute(name: 'messages.index', method: AiluraRoute::GET)]
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
    #[AiluraRoute(name: 'messages.show', method: AiluraRoute::GET, path: '/{id}')]
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
    #[AiluraRoute(name: 'messages.destroy', method: AiluraRoute::DELETE, path: '/{id}')]
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
}
