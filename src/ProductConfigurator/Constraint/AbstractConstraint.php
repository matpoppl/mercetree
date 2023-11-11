<?php

namespace Mateusz\Mercetree\ProductConfigurator\Constraint;

/**
 * @template T
 * @implements ConstraintInterface<T>
 */
abstract class AbstractConstraint implements ConstraintInterface
{
    public function getValidatorType() : string
    {
        return static::class . 'Validator';
    }
}
