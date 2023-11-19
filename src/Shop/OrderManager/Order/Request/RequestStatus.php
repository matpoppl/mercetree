<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Order\Request;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreatedOrderInterface;

class RequestStatus implements RequestStatusInterface
{
    private array $decreasedItems = [];
    private ?CreatedOrderInterface $createdOrder = null;

    public function getDecreasedItems() : array
    {
        return $this->decreasedItems;
    }

    public function setDecreasedItems(array $items) : void
    {
        $this->decreasedItems = $items;
    }

    public function getCreatedOrder() : ?CreatedOrderInterface
    {
        return $this->createdOrder;
    }

    public function setCreatedOrder(CreatedOrderInterface $createdOrder) : void
    {
        $this->createdOrder = $createdOrder;
    }

    public function isCompleted(): bool
    {
        return !empty($this->createdOrder) && !empty($this->decreasedItems);
    }
}
