<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

interface WarehouseReadRepositoryInterface extends WarehouseLockItemRepositoryInterface, WarehouseWriteRepositoryInterface
{
    public function readStockQuantity(string $itemId) : int;
}
