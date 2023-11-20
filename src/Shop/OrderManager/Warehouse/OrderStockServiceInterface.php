<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;

interface OrderStockServiceInterface
{
    /**
     * @throws OrderStockManagerExceptionInterface
     */
    public function decreaseStock(OrderRequestInterface $request) : bool;
    
    /**
     * @throws OrderStockManagerExceptionInterface
     */
    public function confirmDecrease(OrderRequestInterface $request) : bool;

    public function cancelDecrease(OrderRequestInterface $request) : void;
}
