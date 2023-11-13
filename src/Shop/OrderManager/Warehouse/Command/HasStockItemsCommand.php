<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command;

use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseReadRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemInterface;

class HasStockItemsCommand implements CommandInterface
{
    /**
     * @var StockItemInterface[]
     */
    private array $outOfStock = [];

    /**
     * @param WarehouseReadRepositoryInterface $repository
     * @param StockItemInterface[] $items
     */
    public function __construct(private readonly WarehouseReadRepositoryInterface $repository, private readonly array $items)
    {
    }

    public function execute() : bool
    {
        $this->outOfStock = [];

        foreach ($this->items as $item) {
            if ($this->repository->readStockQuantity($item->getStockItemId()) < $item->getQuantity()) {
                $this->outOfStock[] = $item;
            }
        }

        return empty($this->outOfStock);
    }

    /**
     * @return StockItemInterface[]
     */
    public function getOutOtStock() : array
    {
        return $this->outOfStock;
    }
}
