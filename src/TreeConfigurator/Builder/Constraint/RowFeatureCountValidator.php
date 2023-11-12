<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\AbstractConstraintValidator;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ErrorMessage;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidConstraintTypeException;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidValueTypeException;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\RowInterface;

/**
 * @see RowFeatureCount
 */
class RowFeatureCountValidator extends AbstractConstraintValidator
{
    const ERROR_MESSAGE_MIN = 'At lest `{LIMIT}` items required. Found `{COUNT}`.';
    const ERROR_MESSAGE_MAX = 'At most `{LIMIT}` items required. Found `{COUNT}`.';

    public function validate(mixed $value, ConstraintInterface $constraint): void
    {
        if (! $constraint instanceof RowFeatureCount) {
            throw new InvalidConstraintTypeException($constraint, RowFeatureCount::class);
        }

        if (! $value instanceof RowInterface) {
            throw new InvalidValueTypeException($value, RowInterface::class);
        }

        $count = iterator_count($value->getFeatures());

        if (null !== $constraint->min && $count < $constraint->min) {
            $this->context->addError(new ErrorMessage(self::ERROR_MESSAGE_MIN, ['{COUNT}' => $count, '{LIMIT}' => $constraint->min], RowFeatureCount::class));
        }

        if (null !== $constraint->max && $count > $constraint->max) {
            $this->context->addError(new ErrorMessage(self::ERROR_MESSAGE_MAX, ['{COUNT}' => $count, '{LIMIT}' => $constraint->min], RowFeatureCount::class));
        }
    }
}
