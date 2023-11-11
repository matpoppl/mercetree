<?php

namespace Mateusz\Mercetree\ProductConfigurator\Constraint;

class MockConstraint implements ConstraintInterface
{
    public function getValidatorType() : string
    {
        return 'NEVER_USED';
    }
}
