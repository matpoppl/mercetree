<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Result;

use Traversable;

/**
 * @extends Traversable<RowInterface>
 */
interface RowsInterface extends Traversable
{
    public function has(string $rowId) : bool;

    /**
     * @throws RowExceptionInterface
     */
    public function get(string $rowId) : RowInterface;
}
