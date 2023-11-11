<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\BuiltTreeInterface;

interface TreeBuilderInterface
{
    public function addConstraint(ConstraintInterface $constraint) : TreeBuilderInterface;

    public function addRow(string $rowId) : RowBuilderInterface;

    public function getRow(string $rowId) : RowBuilderInterface;

    public function buildTree() : BuiltTreeInterface;
}
