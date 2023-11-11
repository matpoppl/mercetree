<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\Collector;

use Mateusz\Mercetree\Shop\Product\View\ProductInterface;

interface ProductCollectorInterface
{
    public function getBaseProduct() : ProductInterface;

    /**
     * @return ProductInterface[]
     */
    public function getDecorations() : array;
}
