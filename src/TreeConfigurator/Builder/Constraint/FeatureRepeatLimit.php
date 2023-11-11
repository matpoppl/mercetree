<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\AbstractConstraint;
use Mateusz\Mercetree\ProductConfigurator\Constraint\Exception\InvalidOptionsException;

/**
 * @extends AbstractConstraint<FeatureRepeatLimitValidator>
 */
class FeatureRepeatLimit extends AbstractConstraint
{
    public function __construct(public readonly ?int $min = null, public readonly ?int $max = null)
    {
        if (null === $min && null === $max) {
            throw new InvalidOptionsException("At least `min` or `max` must be provided");
        }
    }

    public function getValidatorType(): string
    {
        return FeatureRepeatLimitValidator::class;
    }
}
