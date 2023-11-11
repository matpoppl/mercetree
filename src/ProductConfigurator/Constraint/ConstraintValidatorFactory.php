<?php

namespace Mateusz\Mercetree\ProductConfigurator\Constraint;

class ConstraintValidatorFactory
{
    public function __construct(private readonly ValidationContextInterface $validationContext)
    {
    }

    public function create(ConstraintInterface $constraint) : ConstraintValidatorInterface
    {
        $className = $constraint->getValidatorType();

        if (! class_exists($className)) {
            throw new \UnexpectedValueException("Constraint class `{$className}` don't exists");
        }

        if (! is_subclass_of($className, ConstraintValidatorInterface::class)) {
            throw new \UnexpectedValueException("Unsupported constraint class `{$className}`");
        }

        return new $className($this->validationContext);
    }
}
