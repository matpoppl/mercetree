<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Listener\ReadRepository;

use Mateusz\Mercetree\Shop\OrderManager\Event\OrderRequestAcceptedEvent;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\OrderStockServiceInterface;

class OrderRequestAcceptedListener
{

    public function __construct(private readonly OrderStockServiceInterface $service)
    {
    }

    public function __invoke(OrderRequestAcceptedEvent $event) : void
    {
        $this->service->confirmDecrease($event->getOrderRequest());
    }
}
