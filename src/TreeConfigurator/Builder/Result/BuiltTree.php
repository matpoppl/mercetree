<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Result;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintCollectionInterface;

class BuiltTree implements BuiltTreeInterface
{
    public function __construct(private readonly RowsInterface $rows, private readonly ConstraintCollectionInterface $constraints)
    {
    }

    public function getRow(string $rowId) : RowInterface
    {
        return $this->rows->get($rowId);
    }

    public function getRows() : RowsInterface
    {
        return $this->rows;
    }

    public function getConstraints() : ConstraintCollectionInterface
    {
        return $this->constraints;
    }
}
