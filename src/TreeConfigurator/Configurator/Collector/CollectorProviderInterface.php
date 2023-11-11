<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\Collector;

interface CollectorProviderInterface
{
    public function get(string $baseProductId) : FeatureCollectorInterface;
}
