<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Listener;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderServiceInterface;
use Mateusz\Mercetree\Shop\OrderManager\Event\OrderRequestCancelledEvent;

class OrderRequestCancelledListener
{
    public function __construct(private readonly CreateOrderServiceInterface $service)
    {
    }

    public function __invoke(OrderRequestCancelledEvent $event) : void
    {
        $this->service->cancelOrder($event->getOrderRequest());
    }
}
