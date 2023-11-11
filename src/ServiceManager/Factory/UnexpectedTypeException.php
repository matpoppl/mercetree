<?php

namespace Mateusz\Mercetree\ServiceManager\Factory;

use Throwable;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;

class UnexpectedTypeException extends \Exception
{
    public function __construct(string $type, string $expectedType)
    {
        parent::__construct("Class `{$type}` is not of expected type `{$expectedType}`");
    }
}
