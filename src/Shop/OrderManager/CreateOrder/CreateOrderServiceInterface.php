<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder;

use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;

interface CreateOrderServiceInterface
{
    /**
     * @throws CreateOrderExceptionInterface
     */
    public function createOrder(OrderRequestInterface $request) : bool;
    
    /**
     * @throws CreateOrderExceptionInterface
     */
    public function confirmOrder(OrderRequestInterface $request) : bool;
    public function cancelOrder(OrderRequestInterface $request) : void;
}
