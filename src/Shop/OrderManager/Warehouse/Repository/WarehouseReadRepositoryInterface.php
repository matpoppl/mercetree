<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

use Mateusz\Mercetree\EntityManager\Repository\RepositoryExceptionInterface;

interface WarehouseReadRepositoryInterface extends WarehouseLockItemRepositoryInterface, WarehouseWriteRepositoryInterface
{
    /**
     * @throws RepositoryExceptionInterface
     */
    public function readStockQuantity(string $itemId) : int;
}
