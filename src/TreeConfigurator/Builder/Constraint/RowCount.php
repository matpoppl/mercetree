<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\AbstractConstraint;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidOptionsException;

/**
 * @extends AbstractConstraint<RowCountValidator>
 */
class RowCount extends AbstractConstraint
{
    public function __construct(public readonly ?int $min = null, public readonly ?int $max = null)
    {
        if (null === $min && null === $max) {
            throw new InvalidOptionsException("At least `min` or `max` must be provided");
        }
        if (null !== $min && null !== $max && $min >  $max) {
            throw new InvalidOptionsException("Invalid logic where `min` > `max`");
        }
    }

    public function getValidatorType(): string
    {
        return RowCountValidator::class;
    }
}
