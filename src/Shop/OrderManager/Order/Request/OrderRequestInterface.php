<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Order\Request;

interface OrderRequestInterface
{
    public function getId() : string;

    /**
     * @return OrderRequestItemInterface[]
     */
    public function getItems() : array;
}
