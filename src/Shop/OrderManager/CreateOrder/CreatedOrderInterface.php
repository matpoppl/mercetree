<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder;

use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderEntityInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderItemsEntityInterface;

interface CreatedOrderInterface
{
    public function getOrder() : OrderEntityInterface;

    public function getItems() : OrderItemsEntityInterface;
}
