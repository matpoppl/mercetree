<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command;

use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseWriteRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemInterface;

class IncreaseStockItemsCommand implements CommandInterface
{
    /**
     * @var StockItemInterface[]
     */
    private array $increased = [];

    /**
     * @param WarehouseWriteRepositoryInterface $repository
     * @param StockItemInterface[] $items
     */
    public function __construct(private readonly WarehouseWriteRepositoryInterface $repository, private readonly array $items)
    {
    }

    public function execute() : bool
    {
        $this->increased = [];

        foreach ($this->items as $item) {
            if (! $this->repository->increaseStock($item->getStockItemId(), $item->getQuantity())) {
                return false;
            }
            $this->increased[] = $item;
        }

        return true;
    }

    /**
     * @return StockItemInterface[]
     */
    public function getIncreased() : array
    {
        return $this->increased;
    }
}
