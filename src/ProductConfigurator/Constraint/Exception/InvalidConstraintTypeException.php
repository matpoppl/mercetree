<?php

namespace Mateusz\Mercetree\ProductConfigurator\Constraint\Exception;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintInterface;

class InvalidConstraintTypeException extends \UnexpectedValueException
{
    public function __construct(ConstraintInterface $invalidConstraint, string $expectedType)
    {
        $invalidType = get_class($invalidConstraint);
        parent::__construct("Expecting constraint of `{$expectedType}` type, `{$invalidType}` given");
    }
}
