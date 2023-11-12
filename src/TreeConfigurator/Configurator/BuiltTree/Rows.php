<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\BuiltTree;

use Mateusz\Mercetree\TreeConfigurator\Builder\Result\RowsInterface as ResultRowsInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\Collector\FeatureCollectorInterface;
use IteratorAggregate;
use ArrayIterator;
use Traversable;

/**
 * @implements IteratorAggregate<RowInterface>
 */
class Rows implements RowsInterface, IteratorAggregate
{
    /**
     * @var RowInterface[]
     */
    private array $rows = [];

    public function __construct(private readonly ResultRowsInterface $baseRows, private readonly FeatureCollectorInterface $collector)
    {
    }

    public function get(string $rowId) : RowInterface
    {
        $this->rows[$rowId] = new Row($rowId, $this->baseRows->get($rowId), $this->collector);
        return $this->rows[$rowId];
    }

    /**
     * @return Traversable<RowInterface>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->rows);
    }
}
