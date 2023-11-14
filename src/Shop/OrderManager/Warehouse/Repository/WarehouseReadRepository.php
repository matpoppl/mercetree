<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

class WarehouseReadRepository implements WarehouseReadRepositoryInterface
{
    public function __construct(private readonly MockReadAdapter $adapter)
    {
    }

    public function readStockQuantity(string $itemId) : int
    {
        return $this->adapter->readStockQuantity($itemId);
    }

    public function transactionBegin(): bool
    {
        return $this->adapter->transactionBegin();
    }

    public function transactionRollback(): bool
    {
        return $this->adapter->transactionRollback();
    }

    public function transactionCommit(): bool
    {
        return $this->adapter->transactionCommit();
    }

    public function lockStockItem(string $itemId, int $quantity): bool
    {
        return $this->adapter->lockStockItem($itemId, $quantity);
    }

    public function decreaseStock(string $itemId, int $quantity): bool
    {
        return $this->adapter->decreaseStock($itemId, $quantity);
    }

    public function increaseStock(string $itemId, int $quantity): bool
    {
        return $this->adapter->increaseStock($itemId, $quantity);
    }
}
