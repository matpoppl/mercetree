<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Listener\ReadRepository;

use Mateusz\Mercetree\Shop\OrderManager\Event\OrderRequestCreatedEvent;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\OrderStockServiceInterface;

class OrderRequestCreatedListener
{
    public function __construct(private readonly OrderStockServiceInterface $service)
    {
    }

    public function __invoke(OrderRequestCreatedEvent $event) : void
    {
        $this->service->decreaseStock($event->getOrderRequest());
    }
}
