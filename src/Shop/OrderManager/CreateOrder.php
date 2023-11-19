<?php

namespace Mateusz\Mercetree\Shop\OrderManager;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreatedOrderInterface;
use Mateusz\Mercetree\Shop\OrderManager\Event\CreateOrderEventManagerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Event\OrderRequestAcceptedEvent;
use Mateusz\Mercetree\Shop\OrderManager\Event\OrderRequestCancelledEvent;
use Mateusz\Mercetree\Shop\OrderManager\Event\OrderRequestCreatedEvent;
use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Request\RequestStatusManagerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Event\OrderStockRestoreEvent;

class CreateOrder implements CreateOrderInterface
{
    public function __construct(private readonly CreateOrderEventManagerInterface $eventManager, private readonly RequestStatusManagerInterface $requestStatusManager)
    {
    }

    public function create(OrderRequestInterface $request): ?CreatedOrderInterface
    {
        $this->requestStatusManager->createRequestStatus($request->getId());

        $this->eventManager->dispatch(new OrderRequestCreatedEvent($request));

        $status = $this->requestStatusManager->getOrderRequestStatus($request->getId());

        if ($status->isCompleted()) {
            $this->eventManager->dispatch(new OrderRequestAcceptedEvent($request));
            return $status->getCreatedOrder();
        }

        if ($status->getCreatedOrder()) {
            $this->eventManager->dispatch(new OrderRequestCancelledEvent($request));
        }

        if ($decreased = $status->getDecreasedItems()) {
            $this->eventManager->dispatch(new OrderStockRestoreEvent($request->getId(), $decreased));
        }

        return null;
    }
}
