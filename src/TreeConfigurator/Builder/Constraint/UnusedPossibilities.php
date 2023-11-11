<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint;

use Mateusz\Mercetree\ProductConfigurator\Constraint\AbstractConstraint;

/**
 * @extends AbstractConstraint<UnusedPossibilitiesValidator>
 */
class UnusedPossibilities extends AbstractConstraint
{
    public readonly int $totalSlotsCount;
    public readonly array $symbols;

    public function __construct(array $rowCounts, array $symbols)
    {
        // (n*(n+1))/2
        $this->symbols = array_combine($symbols, $symbols);
        // use symbols count when there are more slots than unique symbols
        $this->totalSlotsCount = min(array_sum($rowCounts), count($this->symbols));
    }

    public function getValidatorType(): string
    {
        return UnusedPossibilitiesValidator::class;
    }
}
