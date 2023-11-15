<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Command;

use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemInterface;

class WarehouseSubmitCommand implements CommandInterface
{
    /**
     * @param StockItemInterface[] $items
     */
    public function __construct(private readonly array $items)
    {
    }

    /**
     * @return StockItemInterface[]
     */
    public function getStockItems() : array
    {
        return $this->items;
    }
}
