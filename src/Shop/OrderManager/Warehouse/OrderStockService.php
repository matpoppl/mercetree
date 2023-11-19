<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Event\OrderStockDecreasedEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

class OrderStockService implements OrderStockServiceInterface
{
    public function __construct(private readonly OrderStockManagerInterface $manager, private readonly EventDispatcherInterface $eventDispatcher, private readonly LoggerInterface $logger)
    {
    }

    public function decreaseStock(OrderRequestInterface $request) : void
    {
        try {
            $records = $this->manager->decreaseStock($request->getItems());
        } catch (OrderStockManagerExceptionInterface $exception) {
            $records = false;
            $this->logger->error("Warehouse decrease stock error", [
                'exception' => $exception,
            ]);
        }

        if (false !== $records) {
            $this->eventDispatcher->dispatch(new OrderStockDecreasedEvent($request->getId(), $records));
        }
    }

    public function confirmDecrease(OrderRequestInterface $request) : void
    {
        try {
            $this->manager->confirmDecrease();
        } catch (OrderStockManagerExceptionInterface $exception) {
            $this->logger->error("Warehouse decrease stock error", [
                'exception' => $exception,
            ]);
        }
    }

    public function cancelDecrease(OrderRequestInterface $request) : void
    {
        try {
            $this->manager->cancelDecrease();
        } catch (OrderStockManagerExceptionInterface $exception) {
            $this->logger->error("Warehouse decrease stock error", [
                'exception' => $exception,
            ]);
        }
    }
}
