<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder;

use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderEntityInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderItemsEntityInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;

class CreateOrderManager implements CreateOrderManagerInterface
{
    /**
     * @throws CreateOrderExceptionInterface
     */
    public function createOrder(OrderRequestInterface $order) : OrderEntityInterface
    {
        echo '[DEBUG] ' . __METHOD__ . "()\n";
        return new MockOrderEntity( date('Y-m-d H:i:s') );
    }

    public function createOrderItems(OrderEntityInterface $order, OrderRequestInterface $orderRequest) : OrderItemsEntityInterface
    {
        echo '[DEBUG] ' . __METHOD__ . "({$order->getId()})\n";
        $items = array_map(fn($item) => new MockOrderItemEntity($order->getId(), $item->getStockItemId(), $item->getQuantity()), $orderRequest->getItems());
        return new MockOrderItemsEntity($items);
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
        echo "[DEBUG] [DEBUG] " . __METHOD__ . "()\n";
        return true;
    }
}
