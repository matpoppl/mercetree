<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintCollection;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\BuiltTreeInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\Rows;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\BuiltTree;

class TreeBuilder implements TreeBuilderInterface
{
    /**
     * @var RowBuilder[]
     */
    private array $rows = [];

    /**
     * @var ConstraintInterface[]
     */
    private array $constraints = [];

    public function addConstraint(ConstraintInterface $constraint) : TreeBuilderInterface
    {
        $this->constraints[] = $constraint;
        return $this;
    }

    public function addRow(string $rowId) : RowBuilderInterface
    {
        return $this->rows[$rowId] = new RowBuilder($this, $rowId);
    }

    public function getRow(string $rowId) : RowBuilderInterface
    {
        if (array_key_exists($rowId, $this->rows)) {
            return $this->rows[$rowId];
        }
        return $this->addRow($rowId);
    }

    public function buildTree() : BuiltTreeInterface
    {
        $rows = new Rows( array_map(fn($row) => $row->buildRow(), $this->rows) );
        return new BuiltTree($rows, new ConstraintCollection($this->constraints));
    }
}
