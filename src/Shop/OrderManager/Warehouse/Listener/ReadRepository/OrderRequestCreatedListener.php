<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Listener\ReadRepository;

use Mateusz\Mercetree\Shop\OrderManager\Event\OrderRequestCreatedEvent;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\OrderStockServiceInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\OrderStockManagerExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\OrderStockManagerException;

class OrderRequestCreatedListener
{
    public function __construct(private readonly OrderStockServiceInterface $service)
    {
    }

    public function __invoke(OrderRequestCreatedEvent $event) : void
    {
        try {
            if ($this->service->decreaseStock($event->getOrderRequest())) {
                return;
            }
        } catch (OrderStockManagerExceptionInterface $exception) {
            $event->stopPropagation($exception);
            return;
        }
        
        $event->stopPropagation(new OrderStockManagerException('Unknown OrderStockService decrease error'));
    }
}
