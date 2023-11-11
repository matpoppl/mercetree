<?php

namespace Mateusz\Mercetree\ProductConfigurator\Constraint\Exception;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintInterface;

class InvalidOptionsException extends \UnexpectedValueException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
