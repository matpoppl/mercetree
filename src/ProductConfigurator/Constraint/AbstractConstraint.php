<?php

namespace Mateusz\Mercetree\ProductConfigurator\Constraint;

abstract class AbstractConstraint implements ConstraintInterface
{
    public function getValidatorType() : string
    {
        return static::class . 'Validator';
    }
}
