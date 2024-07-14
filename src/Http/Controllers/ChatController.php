<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Http\Controllers;

use AiluraCode\Wappify\Attributes\Controller as AiluraController;
use AiluraCode\Wappify\Attributes\Route as AiluraRoute;
use AiluraCode\Wappify\Models\Whatsapp;
use Illuminate\Routing\Controller;

#[AiluraController(name: 'chat', prefix: 'chat')]
final class ChatController extends Controller
{
    /**
     * Get all messages in a specific chat.
     *
     * @return Whatsapp[]
     */
    #[AiluraRoute(name: 'chat', method: AiluraRoute::GET, path: '/{from}')]
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
    #[AiluraRoute(name: 'chat.me', method: AiluraRoute::GET, path: '/me')]
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
    #[AiluraRoute(name: 'chat.you', method: AiluraRoute::GET, path: '/you')]
    public function you(): array
    {
        // @phpstan-ignore-next-line
        return Whatsapp::you()->get();
    }
}
