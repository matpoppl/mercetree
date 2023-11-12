<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary;

use Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary\Presentation\ProductInterface;

interface SaleSummaryInterface
{
    public function getBaseProduct() : ProductInterface;

    /**
     * @return ProductInterface[]
     */
    public function getDecorations() : array;

    public function getProductsSummary() : ProductsSummaryInterface;
}
