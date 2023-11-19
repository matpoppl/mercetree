<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Listener\ReadRepository;

use Mateusz\Mercetree\Shop\OrderManager\Event\OrderRequestCancelledEvent;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\OrderStockServiceInterface;

class OrderRequestCancelledListener
{

    public function __construct(private readonly OrderStockServiceInterface $service)
    {
    }

    public function __invoke(OrderRequestCancelledEvent $event) : void
    {
        $this->service->cancelDecrease($event->getOrderRequest());
    }
}
