<?php

namespace Mateusz\Mercetree\ProductConfigurator\Constraint\Exception;

class UndefinedBehaviourException extends \UnexpectedValueException
{
    public function __construct(string $message)
    {
        parent::__construct($message);
    }
}
