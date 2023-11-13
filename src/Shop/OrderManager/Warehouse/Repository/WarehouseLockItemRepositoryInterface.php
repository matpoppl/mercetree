<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

use Mateusz\Mercetree\EntityManager\Repository\TransactionRepositoryInterface;

interface WarehouseLockItemRepositoryInterface extends TransactionRepositoryInterface
{
    public function lockStockItem(string $itemId, int $quantity) : bool;

    public function unlockStockItem(string $itemId, int $quantity) : bool;
}
