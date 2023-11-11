<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintInterface;

interface RowBuilderInterface
{
    public function addConstraint(ConstraintInterface $constraint) : RowBuilderInterface;

    public function tree() : TreeBuilderInterface;

    public function buildRow() : Result\RowInterface;
}
