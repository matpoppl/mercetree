<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder;

use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderEntityInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderItemsEntityInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;

interface CreateOrderManagerInterface
{
    /**
     * @throws CreateOrderExceptionInterface
     */
    public function createOrder(OrderRequestInterface $order) : OrderEntityInterface;

    /**
     * @throws CreateOrderExceptionInterface
     */
    public function createOrderItems(OrderEntityInterface $order, OrderRequestInterface $orderRequest) : OrderItemsEntityInterface;

    /**
     * @throws CreateOrderExceptionInterface
     */
    public function transactionBegin() : bool;

    /**
     * @throws CreateOrderExceptionInterface
     */
    public function transactionCommit() : bool;

    /**
     * @throws CreateOrderExceptionInterface
     */
    public function transactionRollback() : bool;
}
