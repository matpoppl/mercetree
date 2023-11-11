<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\BuiltTree;

interface RowInterface
{
    public function add(string $featureId) : RowInterface;
}
