<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command;

use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseLockItemRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemInterface;

class UnlockStockItemsCommand implements CommandInterface
{
    /**
     * @var StockItemInterface[]
     */
    private array $stillLocked = [];

    /**
     * @param WarehouseLockItemRepositoryInterface $repository
     * @param StockItemInterface[] $items
     */
    public function __construct(private readonly WarehouseLockItemRepositoryInterface $repository, private readonly array $items)
    {
    }

    public function execute() : bool
    {
        $this->stillLocked = [];

        foreach ($this->items as $item) {
            if (! $this->repository->unlockStockItem($item->getStockItemId(), $item->getQuantity())) {
                $this->stillLocked[] = $item;
            }
        }

        return empty($this->stillLocked);
    }

    /**
     * @return StockItemInterface[]
     */
    public function getStillLocked() : array
    {
        return $this->stillLocked;
    }
}
