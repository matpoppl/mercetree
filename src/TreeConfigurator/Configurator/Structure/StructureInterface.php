<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\Structure;

use Mateusz\Mercetree\TreeConfigurator\Builder\Result\RowsInterface;

interface StructureInterface
{
    public function getRowsCount() : int;

    public function getRows() : RowsInterface;
}
