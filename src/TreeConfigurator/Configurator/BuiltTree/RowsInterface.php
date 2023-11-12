<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\BuiltTree;

use Mateusz\Mercetree\TreeConfigurator\Builder\Result\RowExceptionInterface;

interface RowsInterface
{
    /**
     * @throws RowExceptionInterface
     */
    public function get(string $rowId) : RowInterface;
}
