<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Listener;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreatedOrder;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreatedOrderInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderManagerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Event\CreateOrderProcessEventInterface;

class CreateOrderProcessListener
{
    public function __construct(private readonly CreateOrderManagerInterface $manager)
    {
    }

    public function __invoke(object $event) : void
    {
        if (! $event instanceof CreateOrderProcessEventInterface) {
            return;
        }

        $request = $event->getOrderRequest();

        try {
            $order = $this->manager->createOrder($request);
            $items = $this->manager->createOrderItems($order, $request);

            $event->setProcessedData(CreatedOrderInterface::class, new CreatedOrder($order, $items));
        } catch (CreateOrderExceptionInterface $exception) {
            $event->stopPropagation($exception);
        }
    }
}
