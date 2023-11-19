<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Event;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreatedOrderInterface;

class CreatedOrderEvent
{
    public function __construct(private readonly string $requestId, private readonly CreatedOrderInterface $createdOrder)
    {
    }

    public function getRequestId() : string
    {
        return $this->requestId;
    }

    public function getCreatedOrder() : CreatedOrderInterface
    {
        return $this->createdOrder;
    }
}
