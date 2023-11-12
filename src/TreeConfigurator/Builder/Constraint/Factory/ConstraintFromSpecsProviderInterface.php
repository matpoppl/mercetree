<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint\Factory;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintInterface;

interface ConstraintFromSpecsProviderInterface
{
    /**
     * @param ConstraintSpecsInterface $specs
     * @return ConstraintInterface|null
     */
    public function __invoke(ConstraintSpecsInterface $specs) : ?ConstraintInterface;
}
