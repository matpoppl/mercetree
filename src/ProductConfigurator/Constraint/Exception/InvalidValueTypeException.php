<?php

namespace Mateusz\Mercetree\ProductConfigurator\Constraint\Exception;

class InvalidValueTypeException extends \UnexpectedValueException
{
    public function __construct(mixed $data, string $expectedType)
    {
        $invalidType = is_object($data) ? get_class($data) : gettype($data);
        parent::__construct("Expecting data type`{$invalidType}`, expecting `{$expectedType}`");
    }
}
