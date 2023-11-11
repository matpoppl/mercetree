<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint\Factory;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintInterface;

interface ConstraintFromSpecsProviderInterface
{
    public function __invoke(ConstraintSpecsInterface $specs) : ConstraintInterface;
}
