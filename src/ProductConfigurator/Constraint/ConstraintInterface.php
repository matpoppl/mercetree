<?php

namespace Mateusz\Mercetree\ProductConfigurator\Constraint;

/**
 * @template T on ConstraintValidatorInterface
 */
interface ConstraintInterface
{
    /**
     * @return class-string<T>
     */
    public function getValidatorType() : string;
}
