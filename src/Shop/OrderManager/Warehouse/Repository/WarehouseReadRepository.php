<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestItemInterface;

class WarehouseReadRepository implements WarehouseReadRepositoryInterface, WarehouseRepositoryInterface
{
    public function __construct(private readonly MockReadAdapter $adapter)
    {
    }

    public function begin(array $items): bool
    {
        if (! $this->transactionBegin()) {
            throw new RepositoryException("Transaction begin error");
        }
        
        foreach($items as $item) {
            if (! $this->lockStockItem($item->getStockItemId(), $item->getQuantity())) {
                throw new RepositoryException("StockItem lock error `{$item->getStockItemId()}`/`{$item->getQuantity()}`");
            }
        }
        
        foreach($items as $item) {
            if (! $this->decreaseStock($item->getStockItemId(), $item->getQuantity())) {
                throw new RepositoryException("StockItem decrease stock error `{$item->getStockItemId()}`/`{$item->getQuantity()}`");
            }
        }
        
        return true;
    }
    
    public function commit(): bool
    {
        if (! $this->transactionCommit()) {
            throw new RepositoryException("Transaction commit error");
        }
        
        return true;
    }
    
    public function rollback(): bool
    {
        if (! $this->transactionRollback()) {
            throw new RepositoryException("Transaction rollback error");
        }
        
        return true;
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
