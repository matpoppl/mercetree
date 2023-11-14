<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder;

use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderEntityInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderItemEntityInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;

class CreateOrderManager implements CreateOrderManagerInterface
{
    /**
     * @throws CreateOrderExceptionInterface
     */
    public function createOrder(OrderRequestInterface $order) : OrderEntityInterface
    {
        return new MockOrderEntity( date('Y-m-d H:i:s') );
    }

    /**
     * @param OrderEntityInterface $order
     * @param OrderRequestInterface $orderRequest
     * @return OrderItemEntityInterface[]
     * @throws CreateOrderExceptionInterface
     */
    public function createOrderItems(OrderEntityInterface $order, OrderRequestInterface $orderRequest) : array
    {
        return array_map(fn($item) => new MockOrderItemEntity($order->getId(), $item->getStockItemId(), $item->getQuantity()), $orderRequest->getItems());
    }

    /**
     * @throws CreateOrderExceptionInterface
     */
    public function transactionBegin() : bool
    {
        echo '[DEBUG] ' . __METHOD__ . "()\n";
        return true;
    }

    /**
     * @throws CreateOrderExceptionInterface
     */
    public function transactionCommit() : bool
    {
        echo '[DEBUG] ' . __METHOD__ . "()\n";
        return true;
    }

    /**
     * @throws CreateOrderExceptionInterface
     */
    public function transactionRollback() : bool
    {
        echo '[DEBUG] ' . __METHOD__ . "()\n";
        return true;
    }
}
