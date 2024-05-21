<?php

namespace AiluraCode\Wappify\Concern;

trait Texteable
{
    public function getBody(): string
    {
        return $this->body;
    }
}
