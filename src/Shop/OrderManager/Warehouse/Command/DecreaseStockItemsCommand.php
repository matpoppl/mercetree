<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command;

use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemInterface;

class DecreaseStockItemsCommand implements CommandInterface
{
    /**
     * @param StockItemInterface[] $items
     */
    public function __construct(public readonly string $repoId, public readonly array $items)
    {
    }

    public function getRepositoryId() : string
    {
        return $this->repoId;
    }

    /**
     * @return StockItemInterface[]
     */
    public function getStockItems() : array
    {
        return $this->items;
    }
}
