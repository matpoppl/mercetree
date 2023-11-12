<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\BuiltTree;

use Mateusz\Mercetree\TreeConfigurator\Configurator\Collector\ProductException;

interface RowInterface
{
    /**
     * @throws ProductException
     */
    public function add(string $featureId) : RowInterface;
}
