<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Listener;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderServiceInterface;
use Mateusz\Mercetree\Shop\OrderManager\Event\OrderRequestCreatedEvent;

class OrderRequestCreatedListener
{
    public function __construct(private readonly CreateOrderServiceInterface $service)
    {
    }

    public function __invoke(OrderRequestCreatedEvent $event) : void
    {
        $this->service->createOrder($event->getOrderRequest());
    }
}
