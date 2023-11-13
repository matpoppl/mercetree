<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

use Mateusz\Mercetree\EntityManager\Repository\TransactionalRepositoryInterface;

interface WarehouseWriteRepositoryInterface extends TransactionalRepositoryInterface
{
    public function decreaseStock(string $itemId, int $quantity) : bool;
    public function increaseStock(string $itemId, int $quantity) : bool;
}
