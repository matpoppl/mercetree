<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Order\Request;

class MockOrderRequestItem implements OrderRequestItemInterface
{
    public function __construct(private readonly string $stockItemId, private readonly int $quantity)
    {
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }

    public function getStockItemId(): string
    {
        return $this->stockItemId;
    }
}
