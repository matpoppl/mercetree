<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Listener;

use Mateusz\Mercetree\Shop\OrderManager\Order\Request\RequestStatusManagerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Event\OrderStockDecreasedEvent;

class OrderStockDecreasedListener
{
    public function __construct(private readonly RequestStatusManagerInterface $requestStatusManager)
    {
    }

    public function __invoke(OrderStockDecreasedEvent $event) : void
    {
        $requestStatus = $this->requestStatusManager->getOrderRequestStatus($event->getRequestId());

        if (! $requestStatus) {
            throw new \UnexpectedValueException("Status for OrderRequest `{$event->getRequestId()}` not found");
        }

        $requestStatus->setDecreasedItems($event->getItems());
    }
}
