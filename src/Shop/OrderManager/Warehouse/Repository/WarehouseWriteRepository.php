<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

class WarehouseWriteRepository implements WarehouseWriteRepositoryInterface
{
    public function __construct(private readonly MockWriteAdapter $adapter)
    {
    }

    public function decreaseStock(string $itemId, int $quantity) : bool
    {
        return $this->adapter->decreaseStock($itemId, $quantity);
    }

    public function increaseStock(string $itemId, int $quantity) : bool
    {
        return $this->adapter->increaseStock($itemId, $quantity);
    }
}
