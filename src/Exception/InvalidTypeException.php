<?php

namespace Mateusz\Mercetree\Exception;

class InvalidTypeException extends \Exception
{
    public function __construct(mixed $given, string $expected, int $code = 0, ?\Throwable $previous = null)
    {
        $type = is_object($given) ? get_class($given) : gettype($given);
        parent::__construct("Invalid type `{$type}`, expecting `{$expected}`", $code, $previous);
    }
}
