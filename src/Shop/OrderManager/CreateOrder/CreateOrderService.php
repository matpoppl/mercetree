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

    public function createOrder(OrderRequestInterface $request) : void
    {
        try {
            if (! $this->manager->transactionBegin()) {
                return;
            }
            $order = $this->manager->createOrder($request);
            $items = $this->manager->createOrderItems($order, $request);
            $createdOrder = new CreatedOrder($order, $items);
        } catch (CreateOrderExceptionInterface $exception) {
            $createdOrder = false;
            $this->logger->critical("CreateOrderManager create order error", [
                'exception' => $exception,
            ]);
        }

        if ($createdOrder) {
            $this->eventDispatcher->dispatch(new CreatedOrderEvent($request->getId(), $createdOrder));
            return;
        }

        try {
            $this->cancelOrder($request);
        } catch (CreateOrderExceptionInterface $exception) {
            $this->logger->critical("CreateOrderManager create order error", [
                'exception' => $exception,
            ]);
        }
    }

    public function confirmOrder(OrderRequestInterface $request): void
    {
        try {
            if ($this->manager->transactionCommit()) {
                return;
            }
            $exception = new CreateOrderException('Manager transaction commit error');
        } catch (CreateOrderExceptionInterface $exception) {
        }

        $this->logger->critical("Manager transaction commit error", [
            'exception' => $exception,
        ]);
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
