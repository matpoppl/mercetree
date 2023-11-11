<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\AbstractConstraintValidator;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintInterface;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ErrorMessage;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidConstraintTypeException;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidValueTypeException;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\BuiltTree;

/**
 * @see RowCount
 */
class RowCountValidator extends AbstractConstraintValidator
{
    const ERROR_MESSAGE_MIN = 'At lest `{LIMIT}` rows required. Found `{COUNT}`.';
    const ERROR_MESSAGE_MAX = 'At most `{LIMIT}` rows required. Found `{COUNT}`.';

    public function validate(mixed $value, ConstraintInterface $constraint): void
    {
        if (! $constraint instanceof RowCount) {
            throw new InvalidConstraintTypeException($constraint, RowCount::class);
        }

        if (! $value instanceof BuiltTree) {
            throw new InvalidValueTypeException($value, BuiltTree::class);
        }

        $count = iterator_count($value->getRows());

        if (null !== $constraint->min && $count < $constraint->min) {
            $this->context->addError(new ErrorMessage(self::ERROR_MESSAGE_MIN, ['{COUNT}' => $count, '{LIMIT}' => $constraint->min], RowCount::class));
        }

        if (null !== $constraint->max && $count > $constraint->max) {
            $this->context->addError(new ErrorMessage(self::ERROR_MESSAGE_MAX, ['{COUNT}' => $count, '{LIMIT}' => $constraint->min], RowCount::class));
        }
    }
}
