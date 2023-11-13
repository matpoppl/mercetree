<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder;

use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderEntityInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderItemEntityInterface;

class CreatedOrder implements CreatedOrderInterface
{
    /**
     * @param OrderEntityInterface $order
     * @param OrderItemEntityInterface[] $items
     */
    public function __construct(private readonly OrderEntityInterface $order, private readonly array $items)
    {
    }

    public function getOrder() : OrderEntityInterface
    {
        return $this->order;
    }

    /**
     * @return OrderItemEntityInterface[]
     */
    public function getItems() : array
    {
        return $this->items;
    }
}
