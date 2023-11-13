<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Order\Request;

interface OrderRequestInterface
{
    /**
     * @return OrderRequestItemInterface[]
     */
    public function getItems() : array;
}
