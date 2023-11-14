<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

interface WarehouseWriteRepositoryInterface
{
    public function decreaseStock(string $itemId, int $quantity) : bool;
    public function increaseStock(string $itemId, int $quantity) : bool;
}
