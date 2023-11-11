<?php

namespace Mateusz\Mercetree\Application\Component;

use Throwable;
use Exception;

class NotFoundException extends Exception implements NotFoundExceptionInterface
{
    public static function create(string $name, ?Throwable $previous = null) : self
    {
        return new self("Component `{$name}` not found", 0, $previous);
    }
}
