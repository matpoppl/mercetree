<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\BuiltTree;

interface RowsInterface
{
    public function get(string $rowId) : RowInterface;
}
