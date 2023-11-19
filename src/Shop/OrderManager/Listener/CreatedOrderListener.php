<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Listener;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Event\CreatedOrderEvent;
use Mateusz\Mercetree\Shop\OrderManager\Order\Request\RequestStatusManagerInterface;

class CreatedOrderListener
{
    public function __construct(private readonly RequestStatusManagerInterface $requestStatusManager)
    {
    }

    public function __invoke(CreatedOrderEvent $event) : void
    {
        $requestStatus = $this->requestStatusManager->getOrderRequestStatus($event->getRequestId());

        if (! $requestStatus) {
            throw new \UnexpectedValueException("Status for OrderRequest `{$event->getRequestId()}` not found");
        }

        $requestStatus->setCreatedOrder($event->getCreatedOrder());
    }
}
