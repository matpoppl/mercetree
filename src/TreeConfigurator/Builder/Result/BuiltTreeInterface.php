<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Result;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintCollectionInterface;

interface BuiltTreeInterface
{
    public function getRow(string $rowId) : RowInterface;

    public function getRows() : RowsInterface;
}
