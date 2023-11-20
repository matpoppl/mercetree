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
use Mateusz\Mercetree\Event\StoppableEventInterface;

class CreateOrder implements CreateOrderInterface
{
    public function __construct(private readonly CreateOrderEventManagerInterface $eventManager, private readonly RequestStatusManagerInterface $requestStatusManager)
    {
    }

    public function create(OrderRequestInterface $request): ?CreatedOrderInterface
    {
        $status = $this->requestStatusManager->createRequestStatus($request->getId());

        try {
            $this->_dispatch(new OrderRequestCreatedEvent($request), "OrderRequestCreatedEvent error");
        } catch (CreateOrderExceptionInterface $ex) {
            $this->rollback($request);
            throw $ex;
        }
        
        if (! $status->isCompleted()) {
            // if (isSynchronous) $this->rollback($request);
            return null;
        }
        
        try {
            $this->_dispatch(new OrderRequestAcceptedEvent($request), "OrderRequestAcceptedEvent error");
        } catch (CreateOrderExceptionInterface $ex) {
            $this->rollback($request);
            throw $ex;
        }
        
        return $status->getCreatedOrder();
    }
    
    private function rollback(OrderRequestInterface $request)
    {
        $status = $this->requestStatusManager->getOrderRequestStatus($request->getId());
        
        if ($status->getCreatedOrder()) {
            $this->eventManager->dispatch(new OrderRequestCancelledEvent($request));
        }
        
        if ($decreased = $status->getDecreasedItems()) {
            $this->eventManager->dispatch(new OrderStockRestoreEvent($request->getId(), $decreased));
        }
    }
    
    /**
     * @throws CreateOrderExceptionInterface
     */
    private function _dispatch(StoppableEventInterface $event, string $exceptionMessage)
    {
        $this->eventManager->dispatch($event);
        
        if (! $event->isPropagationStopped()) {
            return;
        }
        
        $reason = $event->getStopReason();
        
        if (! $reason) {
            return;
        }
        
        throw new CreateOrderException($exceptionMessage, 0, $reason);
    }
}
