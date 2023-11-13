<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder;

use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderEntityInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderItemEntityInterface;

interface CreatedOrderInterface
{
    public function getOrder() : OrderEntityInterface;

    /**
     * @return OrderItemEntityInterface[]
     */
    public function getItems() : array;
}
