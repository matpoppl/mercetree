<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Listener\WriteRepository;

use Mateusz\Mercetree\EntityManager\Repository\RepositoryExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Event\CreateOrderEventInterface;
use Mateusz\Mercetree\Shop\OrderManager\Event\CreateOrderStepEnum;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseWriteRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemsRegistry;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\WarehouseException;
use Psr\Log\LoggerInterface;

class CreateOrderListener
{
    public function __construct(private readonly WarehouseWriteRepositoryInterface $repository, private readonly StockItemsRegistry $registry, private readonly LoggerInterface $logger)
    {
    }

    public function __invoke(object $event) : void
    {
        if (! $event instanceof CreateOrderEventInterface) {
            return;
        }

        try {
            switch ($event->getCurrentStep()) {
                case CreateOrderStepEnum::COMMIT:
                    // noop
                    return;
                case CreateOrderStepEnum::BEGIN:
                    $this->begin($event);
                    return;
                case CreateOrderStepEnum::ROLLBACK:
                    $this->rollback();
                    return;
            }
        } catch (RepositoryExceptionInterface $exception) {
            $event->stopPropagation(new WarehouseException("WarehouseRepository error", 0, $exception));
        }
    }

    /**
     * @throws RepositoryExceptionInterface
     */
    public function begin(CreateOrderEventInterface $event) : void
    {
        foreach ($event->getOrderRequest()->getItems() as $item) {
            if (! $this->repository->decreaseStock($item->getStockItemId(), $item->getQuantity())) {
                $event->stopPropagation(new WarehouseException("WarehouseWriteRepository decrease error"));
                break;
            }
            $this->registry->addDecreased($item);
        }
    }

    /**
     * @throws RepositoryExceptionInterface
     */
    public function rollback() : void
    {
        foreach ($this->registry->getDecreased() as $item) {
            if (! $this->repository->increaseStock($item->getStockItemId(), $item->getQuantity())) {
                $this->logger->error("WarehouseWriteRepository increase error", [
                    'exception' => new WarehouseException("WarehouseWriteRepository decrease error"),
                ]);
                break;
            }
            $this->registry->addIncreased($item);
        }
    }
}
