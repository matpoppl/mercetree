<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Order\Request;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreatedOrderInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemInterface;

interface RequestStatusInterface
{
    public function isCompleted() : bool;

    public function getCreatedOrder() : ?CreatedOrderInterface;
    public function setCreatedOrder(CreatedOrderInterface $createdOrder) : void;

    /**
     * @return StockItemInterface[]
     */
    public function getDecreasedItems() : array;

    /**
     * @param StockItemInterface[] $items
     */
    public function setDecreasedItems(array $items) : void;
}
