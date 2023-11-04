<?php

namespace Mateusz\Mercetree\Application\Component;

class NotFoundException
{
    public static function create(string $name) : self
    {
        return new self("Component `{$name}` not found");
    }
}
