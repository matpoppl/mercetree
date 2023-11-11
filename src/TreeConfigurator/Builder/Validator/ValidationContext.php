<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Validator;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintCollectionInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintValidatorFactory;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ErrorMessageInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ValidationContextInterface;

class ValidationContext implements ValidationContextInterface
{
    /**
     * @var ErrorMessageInterface[]
     */
    private array $errors = [];

    public function __construct()
    {
    }

    public function addError(ErrorMessageInterface $error) : void
    {
        $this->errors[] = $error;
    }

    public function getErrors(): array
    {
        return $this->errors;
    }

    public function validate(mixed $value, ConstraintCollectionInterface $constraints) : bool
    {
        $this->errors = [];

        $factory = new ConstraintValidatorFactory($this);

        foreach ($constraints as $constraint) {
            $validator = $factory->create($constraint);
            $validator->validate($value, $constraint);
        }

        return empty($this->errors);
    }
}
