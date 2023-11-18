<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder;

use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderEntityInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderItemsEntityInterface;

class CreatedOrder implements CreatedOrderInterface
{
    public function __construct(private readonly OrderEntityInterface $order, private readonly OrderItemsEntityInterface $items)
    {
    }

    public function getOrder() : OrderEntityInterface
    {
        return $this->order;
    }

    public function getItems() : OrderItemsEntityInterface
    {
        return $this->items;
    }
}
