<?php

namespace Mateusz\Mercetree\ProductConfigurator\Constraint;

abstract class AbstractConstraintValidator implements ConstraintValidatorInterface
{
    public function __construct(protected readonly ValidationContextInterface $context)
    {
    }
}
