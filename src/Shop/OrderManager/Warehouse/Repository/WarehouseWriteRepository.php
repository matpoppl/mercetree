<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemsRegistry;

class WarehouseWriteRepository implements WarehouseWriteRepositoryInterface, WarehouseRepositoryInterface
{
    public function __construct(private readonly MockWriteAdapter $adapter, private readonly StockItemsRegistry $stockItemsRegistry)
    {
    }
    
    public function begin(array $items): bool
    {
        foreach($items as $item) {
            if (! $this->decreaseStock($item->getStockItemId(), $item->getQuantity())) {
                throw new RepositoryException("StockItem lock error `{$item->getStockItemId()}`/`{$item->getQuantity()}`");
            }
            $this->stockItemsRegistry->addDecreased($item);
        }
        
        return true;
    }
    
    public function commit(): bool
    {
        return true;
    }
    
    /**
     *
     * @throws RepositoryExceptionInterface
     * @return bool
     */
    public function rollback(): bool
    {
        foreach($this->stockItemsRegistry->getDecreased() as $item) {
            if (! $this->increaseStock($item->getStockItemId(), $item->getQuantity())) {
                throw new RepositoryException("StockItem lock error `{$item->getStockItemId()}`/`{$item->getQuantity()}`");
            }
            $this->stockItemsRegistry->addIncreased($item);
        }
        
        return true;
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
