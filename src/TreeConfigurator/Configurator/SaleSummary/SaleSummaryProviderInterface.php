<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary;

use Mateusz\Mercetree\TreeConfigurator\Configurator\Collector\ProductCollectorInterface;

interface SaleSummaryProviderInterface
{
    public function create(ProductCollectorInterface $collector) : SaleSummaryInterface;
}
