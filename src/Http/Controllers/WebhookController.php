<?php

declare(strict_types=1);

namespace AiluraCode\Wappify\Http\Controllers;

use AiluraCode\Wappify\Attributes\Controller as AiluraController;
use AiluraCode\Wappify\Attributes\Route as AiluraRoute;
use AiluraCode\Wappify\Jobs\ReceiveMessageJob;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Config;

#[AiluraController(name: 'webhook', prefix: 'webhook')]
final class WebhookController extends Controller
{
    /**
     * Verify the webhook.
     */
    #[AiluraRoute(name: 'webhook', method: AiluraRoute::GET, path: '{account}')]
    public function webhook(string $account): void
    {
        try {
            webhook($account);
        } catch (\Throwable $e) {
            throw new Exception("Account \"$account\" not found");
        }
    }

    /**
     * Receive a Whatsapp message.
     */
    #[AiluraRoute(name: 'receive', method: AiluraRoute::POST, path: '{account}')]
    public function receive(string $account = 'default'): JsonResponse
    {
        $payload = file_get_contents('php://input');
        $queue = Config::get("wappify.accounts.$account.queue");
        ReceiveMessageJob::dispatch($payload, $account)
            // @phpstan-ignore-next-line
            ->onQueue($queue['name'])
            ->onConnection($queue['connection']);

        // @phpstan-ignore-next-line
        return response()->json(['message' => 'Message received']);
    }
}
