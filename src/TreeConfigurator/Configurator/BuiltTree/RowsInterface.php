<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\BuiltTree;

use Mateusz\Mercetree\TreeConfigurator\Builder\Result\RowExceptionInterface;
use Traversable;

/**
 * @extends Traversable<RowInterface>
 */
interface RowsInterface extends Traversable
{
    /**
     * @throws RowExceptionInterface
     */
    public function get(string $rowId) : RowInterface;
}
