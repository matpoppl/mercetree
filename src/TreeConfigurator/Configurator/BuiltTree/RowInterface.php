<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\BuiltTree;

use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\Collector\ProductException;

interface RowInterface
{
    public function getId() : string;

    /**
     * @throws ProductException
     */
    public function add(string $featureId) : RowInterface;

    /**
     * @return FeatureInterface[]
     */
    public function getFeatures() : array;
}
