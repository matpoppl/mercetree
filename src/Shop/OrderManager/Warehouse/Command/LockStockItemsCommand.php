<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command;

use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseLockItemRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemInterface;

class LockStockItemsCommand implements CommandInterface
{
    /**
     * @var StockItemInterface[]
     */
    private array $locked;

    /**
     * @param WarehouseLockItemRepositoryInterface $repository
     * @param StockItemInterface[] $items
     */
    public function __construct(private readonly WarehouseLockItemRepositoryInterface $repository, private readonly array $items)
    {
    }

    public function execute() : bool
    {
        $this->locked = [];

        foreach ($this->items as $item) {
            if (! $this->repository->lockStockItem($item->getStockItemId(), $item->getQuantity())) {
                return false;
            }
            $this->locked[] = $item;
        }

        return true;
    }

    /**
     * @return StockItemInterface[]
     */
    public function getLocked() : array
    {
        return $this->locked;
    }
}
