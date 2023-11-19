<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Listener;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderServiceInterface;
use Mateusz\Mercetree\Shop\OrderManager\Event\OrderRequestAcceptedEvent;

class OrderRequestAcceptedListener
{
    public function __construct(private readonly CreateOrderServiceInterface $service)
    {
    }

    public function __invoke(OrderRequestAcceptedEvent $event) : void
    {
        $this->service->confirmOrder($event->getOrderRequest());
    }
}
