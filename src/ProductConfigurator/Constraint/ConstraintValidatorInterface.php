<?php

namespace Mateusz\Mercetree\ProductConfigurator\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidConstraintTypeException;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidValueTypeException;

interface ConstraintValidatorInterface
{
    public function __construct(ValidationContextInterface $context);

    /**
     * @param mixed $value
     * @param ConstraintInterface $constraint
     * @return void
     * @throws InvalidValueTypeException
     * @throws InvalidConstraintTypeException
     */
    public function validate(mixed $value, ConstraintInterface $constraint) : void;
}
