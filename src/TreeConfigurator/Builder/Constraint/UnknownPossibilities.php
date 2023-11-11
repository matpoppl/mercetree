<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\AbstractConstraint;

/**
 * @see UnknownPossibilitiesValidator
 */
class UnknownPossibilities extends AbstractConstraint
{
    public readonly array $symbols;

    public function __construct(array $symbols)
    {
        $this->symbols = array_combine($symbols, $symbols);
    }
}
