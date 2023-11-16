<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command;

use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseRepositoryInterface;

/**
 * @template T of WarehouseRepositoryInterface
 */
class RepositoryBeginCommand implements CommandInterface
{
    /**
     * @param class-string<T> $items
     * @param StockItemInterface[] $items
     */
    public function __construct(private readonly string $repository, private readonly array $items)
    {
    }
    
    /**
     * @return StockItemInterface[]
     */
    public function getStockItems() : array
    {
        return $this->items;
    }
    
    /**
     * @return class-string<T>
     */
    public function getRepository() : string
    {
        return $this->repository;
    }
}
