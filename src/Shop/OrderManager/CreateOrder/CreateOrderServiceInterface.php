<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder;

use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;

interface CreateOrderServiceInterface
{
    public function createOrder(OrderRequestInterface $request) : void;
    public function confirmOrder(OrderRequestInterface $request) : void;
    public function cancelOrder(OrderRequestInterface $request) : void;
}
