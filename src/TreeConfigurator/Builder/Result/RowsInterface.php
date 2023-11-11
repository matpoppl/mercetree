<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Result;

use Traversable;

/**
 * @extends Traversable<RowInterface>
 */
interface RowsInterface extends Traversable
{
    public function get(string $rowId) : RowInterface;
}
