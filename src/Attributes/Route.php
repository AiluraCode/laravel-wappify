<?php

namespace AiluraCode\Wappify\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_METHOD)]
class Route
{
    public const GET = 'GET';
    public const POST = 'POST';
    public const PUT = 'PUT';
    public const PATCH = 'PATCH';
    public const DELETE = 'DELETE';

    public function __construct(
        public string $name,
        public string $method,
        public string $path = '',
        public array $middlewares = [],
    ) {
    }
}
