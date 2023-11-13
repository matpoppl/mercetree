<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command;

use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseWriteRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemInterface;

class DecreaseStockItemsCommand implements CommandInterface
{
    /**
     * @var StockItemInterface[]
     */
    private array $decreased = [];

    /**
     * @param WarehouseWriteRepositoryInterface $repository
     * @param StockItemInterface[] $items
     */
    public function __construct(private readonly WarehouseWriteRepositoryInterface $repository, private readonly array $items)
    {
    }

    public function execute() : bool
    {
        $this->decreased = [];

        foreach ($this->items as $item) {
            if (! $this->repository->decreaseStock($item->getStockItemId(), $item->getQuantity())) {
                return false;
            }
            $this->decreased[] = $item;
        }

        return true;
    }

    /**
     * @return StockItemInterface[]
     */
    public function getDecreased() : array
    {
        return $this->decreased;
    }
}
