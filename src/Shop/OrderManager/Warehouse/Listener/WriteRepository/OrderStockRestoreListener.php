<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Listener\WriteRepository;

use Mateusz\Mercetree\EntityManager\Repository\RepositoryExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseWriteRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemsRegistry;

class OrderStockRestoreListener
{
    public function __construct(private readonly WarehouseWriteRepositoryInterface $repository, private readonly StockItemsRegistry $registry)
    {
    }

    /**
     * @throws RepositoryExceptionInterface
     */
    public function __invoke() : void
    {
        foreach ($this->registry->getDecreased() as $item) {
            $this->repository->increaseStock($item->getStockItemId(), $item->getQuantity());
        }
    }
}
