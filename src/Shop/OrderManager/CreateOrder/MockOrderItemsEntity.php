<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder;

use IteratorAggregate;
use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderItemEntityInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderItemsEntityInterface;
use Traversable;
use ArrayIterator;

/**
 * @implements IteratorAggregate<OrderItemEntityInterface>
 */
class MockOrderItemsEntity implements OrderItemsEntityInterface, IteratorAggregate
{
    public function __construct(private readonly array $items)
    {
    }

    /**
     * @return Traversable<OrderItemEntityInterface>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->items);
    }
}
