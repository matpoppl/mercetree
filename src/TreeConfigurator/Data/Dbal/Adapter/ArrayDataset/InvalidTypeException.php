<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset;

class InvalidTypeException extends \Exception
{
    public function __construct(mixed $given, string $expected, ?\Throwable $previous = null)
    {
        $type = is_object($given) ? get_class($given) : gettype($given);
        parent::__construct("Unsupported type `{$type}`, expecting `{$expected}`", 0, $previous);
    }
}
