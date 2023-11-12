<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\BuiltTree;

use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\RowInterface as ResultRowInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\Collector\FeatureCollectorInterface;

class Row implements RowInterface
{
    /**
     * @var FeatureInterface[]
     */
    private array $features = [];

    public function __construct(private readonly string $rowId, private readonly ResultRowInterface $baseRow, private readonly FeatureCollectorInterface $collector)
    {
    }

    public function getId() : string
    {
        return $this->rowId;
    }

    public function add(string $featureId) : RowInterface
    {
        $this->features[$featureId] = $this->baseRow->add( $this->collector->getFeature($featureId) );
        return $this;
    }

    /**
     * @return FeatureInterface[]
     */
    public function getFeatures() : array
    {
        return $this->features;
    }
}
