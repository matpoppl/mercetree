<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintCollection;
use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintInterface;

class RowBuilder implements RowBuilderInterface
{
    /**
     * @var ConstraintInterface[]
     */
    private array $constraints = [];

    public function __construct(private readonly TreeBuilder $tree, private readonly string $rowId)
    {}

    public function addConstraint(ConstraintInterface $constraint) : RowBuilderInterface
    {
        $this->constraints[] = $constraint;
        return $this;
    }

    public function tree() : TreeBuilderInterface
    {
        return $this->tree;
    }

    public function buildRow() : Result\RowInterface
    {
        return new Result\Row($this->rowId, new ConstraintCollection($this->constraints));
    }
}
