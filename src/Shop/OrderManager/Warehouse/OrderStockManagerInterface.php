<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

interface OrderStockManagerInterface
{
    /**
     * @throws OrderStockManagerExceptionInterface
     */
    public function decreaseStock(array $items);

    /**
     * @throws OrderStockManagerExceptionInterface
     */
    public function confirmDecrease() : void;

    /**
     * @throws OrderStockManagerExceptionInterface
     */
    public function cancelDecrease() : void;
}