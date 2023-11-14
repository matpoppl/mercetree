<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Order\Request;

class MockOrderRequest implements OrderRequestInterface
{
    public function __construct(private readonly array $items)
    {
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
