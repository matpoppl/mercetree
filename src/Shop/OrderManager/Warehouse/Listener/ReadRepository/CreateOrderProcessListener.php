<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Listener\ReadRepository;

use Mateusz\Mercetree\EntityManager\Repository\RepositoryExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Event\CreateOrderProcessEventInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseReadRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\WarehouseException;

class CreateOrderProcessListener
{
    public function __construct(private readonly WarehouseReadRepositoryInterface $repository)
    {
    }

    public function __invoke(object $event) : void
    {
        if (! $event instanceof CreateOrderProcessEventInterface) {
            return;
        }

        $order = $event->getOrderRequest();

        try {
            foreach ($order->getItems() as $item) {
                if (! $this->repository->lockStockItem($item->getStockItemId(), $item->getQuantity())) {
                    $event->stopPropagation(new WarehouseException("WarehouseReadRepository lock error"));
                    return;
                }
            }
            foreach ($order->getItems() as $item) {
                if (! $this->repository->decreaseStock($item->getStockItemId(), $item->getQuantity())) {
                    $event->stopPropagation(new WarehouseException("WarehouseReadRepository decrease error"));
                    return;
                }
            }
            return;
        } catch (RepositoryExceptionInterface $exception) {
            $event->stopPropagation($exception);
        }
    }
}
