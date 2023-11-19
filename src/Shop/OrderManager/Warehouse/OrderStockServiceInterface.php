<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;

interface OrderStockServiceInterface
{
    public function decreaseStock(OrderRequestInterface $request) : void;

    public function confirmDecrease(OrderRequestInterface $request) : void;

    public function cancelDecrease(OrderRequestInterface $request) : void;
}
