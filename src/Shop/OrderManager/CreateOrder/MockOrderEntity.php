<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder;

use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderEntityInterface;

class MockOrderEntity implements OrderEntityInterface
{
    public function __construct(private readonly string $orderId)
    {
    }

    public function getId(): string
    {
        return $this->orderId;
    }
}
