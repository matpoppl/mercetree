<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

use Mateusz\Mercetree\EntityManager\Repository\RepositoryExceptionInterface;
use Mateusz\Mercetree\EntityManager\Repository\TransactionalRepositoryInterface;

interface WarehouseLockItemRepositoryInterface extends TransactionalRepositoryInterface
{
    /**
     * @throws RepositoryExceptionInterface
     */
    public function lockStockItem(string $itemId, int $quantity) : bool;
}
