<?php

namespace Mateusz\Mercetree\ProductConfigurator\Constraint;

interface ValidationContextInterface
{
    public function addError(ErrorMessageInterface $error);

    /**
     * @return ErrorMessageInterface[]
     */
    public function getErrors() : array;

    public function validate(mixed $value, ConstraintCollectionInterface $constraints) : bool;
}
