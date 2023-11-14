<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

use Mateusz\Mercetree\EntityManager\Repository\TransactionalRepositoryInterface;

interface WarehouseLockItemRepositoryInterface extends TransactionalRepositoryInterface
{
    public function lockStockItem(string $itemId, int $quantity) : bool;
}
