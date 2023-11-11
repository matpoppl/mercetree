<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\Collector;

interface CollectorProviderInterface
{
    /**
     * @throws ProductException
     */
    public function get(string $baseProductId) : FeatureCollectorInterface;
}
