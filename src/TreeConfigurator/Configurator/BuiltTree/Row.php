<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\BuiltTree;

use Mateusz\Mercetree\TreeConfigurator\Builder\Result\RowInterface as ResultRowInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\Collector\FeatureCollectorInterface;

class Row implements RowInterface
{
    public function __construct(private readonly ResultRowInterface $baseRow, private readonly FeatureCollectorInterface $collector)
    {
    }

    public function add(string $featureId) : RowInterface
    {
        $this->baseRow->add( $this->collector->getFeature($featureId) );
        return $this;
    }
}
