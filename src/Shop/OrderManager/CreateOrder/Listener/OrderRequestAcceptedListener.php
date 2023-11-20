<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Listener;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderServiceInterface;
use Mateusz\Mercetree\Shop\OrderManager\Event\OrderRequestAcceptedEvent;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderException;

class OrderRequestAcceptedListener
{
    public function __construct(private readonly CreateOrderServiceInterface $service)
    {
    }

    public function __invoke(OrderRequestAcceptedEvent $event) : void
    {
        try {
            if ($this->service->confirmOrder($event->getOrderRequest())) {
                return;
            }
        } catch (CreateOrderExceptionInterface $exception) {
            $event->stopPropagation($exception);
        }
        
        $event->stopPropagation(new CreateOrderException("Unknown CreateOrderService createOrder error"));
    }
}
