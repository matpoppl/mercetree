<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Listener\WriteRepository;

use Mateusz\Mercetree\EntityManager\Repository\RepositoryExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Event\OrderStockDecreasedEvent;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseWriteRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemsRegistry;
use Psr\Log\LoggerInterface;

class OrderStockDecreasedListener
{
    public function __construct(private readonly WarehouseWriteRepositoryInterface $repository, private readonly StockItemsRegistry $registry, private readonly LoggerInterface $logger)
    {
    }

    /**
     * @throws RepositoryExceptionInterface
     */
    public function __invoke(OrderStockDecreasedEvent $event) : void
    {
        foreach ($event->getItems() as $item) {
            if (! $this->repository->decreaseStock($item->getStockItemId(), $item->getQuantity())) {
                $this->logger->error("Repository decrease stock error", [
                    'exception' => new \RuntimeException("Repository decrease stock error `{$item->getStockItemId()}`/`{$item->getQuantity()}")
                ]);
            }
            $this->registry->addDecreased($item);
        }
    }
}
