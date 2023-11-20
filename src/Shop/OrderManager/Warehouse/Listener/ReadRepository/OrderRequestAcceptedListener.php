<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Listener\ReadRepository;

use Mateusz\Mercetree\Shop\OrderManager\Event\OrderRequestAcceptedEvent;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\OrderStockServiceInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\OrderStockManagerExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\OrderStockManagerException;

class OrderRequestAcceptedListener
{

    public function __construct(private readonly OrderStockServiceInterface $service)
    {
    }

    public function __invoke(OrderRequestAcceptedEvent $event) : void
    {
        try {
            if ($this->service->confirmDecrease($event->getOrderRequest())) {
                return;
            }
        } catch (OrderStockManagerExceptionInterface $exception) {
            $event->stopPropagation($exception);
            return;
        }
        
        $event->stopPropagation(new OrderStockManagerException('Unknown OrderStockService confirm decrease error'));
    }
}
