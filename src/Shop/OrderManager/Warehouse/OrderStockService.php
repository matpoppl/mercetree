<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Event\OrderStockDecreasedEvent;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

class OrderStockService implements OrderStockServiceInterface
{
    public function __construct(
        private readonly OrderStockManagerInterface $manager,
        private readonly EventDispatcherInterface $eventDispatcher,
        private readonly LoggerInterface $logger
    ) {
    }

    public function decreaseStock(OrderRequestInterface $request) : bool
    {
        $records = $this->manager->decreaseStock($request->getItems());

        if (! $records) {
            return false;
        }
        
        $this->eventDispatcher->dispatch(new OrderStockDecreasedEvent($request->getId(), $records));
        return true;
    }

    public function confirmDecrease(OrderRequestInterface $request) : bool
    {
        return $this->manager->confirmDecrease();
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
