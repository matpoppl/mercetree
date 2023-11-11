<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\Collector;

use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureInterface;

interface FeatureCollectorInterface extends ProductCollectorInterface
{
    /**
     * @throws ProductException
     */
    public function getFeature(string $featureId) : FeatureInterface;
}
