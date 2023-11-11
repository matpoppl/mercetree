<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\AbstractConstraint;

/**
 * @extends AbstractConstraint<UnknownPossibilitiesValidator>
 */
class UnknownPossibilities extends AbstractConstraint
{
    public readonly array $symbols;

    public function __construct(array $symbols)
    {
        $this->symbols = array_combine($symbols, $symbols);
    }

    public function getValidatorType(): string
    {
        return UnknownPossibilitiesValidator::class;
    }
}
