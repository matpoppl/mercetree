<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Event\CreatedOrderEvent;
use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

class CreateOrderService implements CreateOrderServiceInterface
{
    public function __construct(private readonly CreateOrderManagerInterface $manager, private readonly EventDispatcherInterface $eventDispatcher, private readonly LoggerInterface $logger)
    {
    }

    public function createOrder(OrderRequestInterface $request) : bool
    {
        if (! $this->manager->transactionBegin()) {
            return false;
        }
        
        try {
            $order = $this->manager->createOrder($request);
            $items = $this->manager->createOrderItems($order, $request);
            $createdOrder = new CreatedOrder($order, $items);
        } catch (CreateOrderExceptionInterface $exception) {
            $createdOrder = null;
        }
        
        if ($createdOrder) {
            $this->eventDispatcher->dispatch(new CreatedOrderEvent($request->getId(), $createdOrder));
            return true;
        }

        try {
            $this->cancelOrder($request);
        } catch (CreateOrderExceptionInterface $exception) {
            $this->logger->critical("CreateOrderManager create order error", [
                'exception' => $exception,
            ]);
        }
        
        return false;
    }

    public function confirmOrder(OrderRequestInterface $request): bool
    {
        if ($this->manager->transactionCommit()) {
            return true;
        }
        
        throw new CreateOrderException('Manager transaction commit error');
    }

    public function cancelOrder(OrderRequestInterface $request): void
    {
        try {
            if ($this->manager->transactionRollback()) {
                return;
            }
            $exception = new CreateOrderException('Manager transaction rollback error');
        } catch (CreateOrderExceptionInterface $exception) {
        }

        $this->logger->critical("Manager transaction rollback error", [
            'exception' => $exception,
        ]);
    }
}
