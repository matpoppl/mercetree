<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Order\Request;

class MockOrderRequest implements OrderRequestInterface
{
    public function __construct(private readonly string $id, private readonly array $items)
    {
    }

    public function getId(): string
    {
        return $this->id;
    }

    public function getItems(): array
    {
        return $this->items;
    }
}
