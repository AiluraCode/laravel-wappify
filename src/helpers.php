<?php

declare(strict_types=1);

use AiluraCode\Wappify\Attributes\Controller as AttributesController;
use AiluraCode\Wappify\Attributes\Route as AttributesRoute;
use AiluraCode\Wappify\WhatsAppCloudApiExtended;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\Route;
use Netflie\WhatsAppCloudApi\WebHook;

/**
 * Get the WhatsAppCloudApi instance.
 *
 * @return WhatsAppCloudApiExtended
 */
function whatsapp(string $account = 'default'): WhatsAppCloudApiExtended
{
    $account = config("wappify.accounts.$account");

    return new WhatsAppCloudApiExtended([
        'from_phone_number_id' => $account['number_id'],
        'access_token'         => $account['token'],
    ]);
}

function webhook(string $account = 'default'): void
{
    $webhook = new WebHook();
    // @phpstan-ignore-next-line
    $account = Config::get("wappify.accounts.$account");
    echo $webhook->verify($_GET, $account['token']);
}

function add_route($class): void
{
    $class = new ReflectionClass($class);
    $classAttributes = $class->getAttributes(AttributesController::class);

    if (empty($classAttributes)) {
        return;
    }

    $instance = $classAttributes[0]->newInstance();
    $prefix = $instance->prefix;
    $middlewares = $instance->middlewares;
    $controllerName = $class->getName();
    $controllerMethods = $class->getMethods();

    Route::prefix($prefix)
        // @phpstan-ignore-next-line
        ->middleware($middlewares)
        ->group(
            function () use ($controllerMethods, $controllerName, $instance): void {
                foreach ($controllerMethods as $method) {
                    $routes = $method->getAttributes(AttributesRoute::class);
                    foreach ($routes as $route) {
                        $instance = $route->newInstance();
                        $path = $instance->path;
                        $middlewares = $instance->middlewares;
                        $name = $instance->name;
                        $httpMethod = $instance->method;

                        Route::match(
                            [$httpMethod],
                            $path,
                            [$controllerName, $method->getName()]
                        )
                            ->name($name)
                            // @phpstan-ignore-next-line
                            ->middleware($middlewares);
                    }
                }
            }
        );
}
