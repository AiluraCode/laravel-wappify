<?php

namespace AiluraCode\Wappify\Attributes;

use Attribute;

#[Attribute(Attribute::TARGET_CLASS)]
class Controller
{
    public function __construct(
        public string $name = '',
        public string $prefix = '',
        public array $middlewares = [],
    ) {
    }
}
