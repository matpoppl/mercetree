<?php

namespace Mateusz\Mercetree\ProductConfigurator\Constraint;

interface ConstraintInterface
{
    /**
     * @return class-string
     */
    public function getValidatorType() : string;
}
