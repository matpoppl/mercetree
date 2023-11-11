<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\BuiltTree;

use Mateusz\Mercetree\TreeConfigurator\Builder\Result\RowsInterface as ResultRowsInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\Collector\FeatureCollectorInterface;

class Rows implements RowsInterface
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
        $this->rows[$rowId] = new Row($this->baseRows->get($rowId), $this->collector);
        return $this->rows[$rowId];
    }
}
