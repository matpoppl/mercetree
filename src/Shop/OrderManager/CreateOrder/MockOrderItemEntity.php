<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder;

use Mateusz\Mercetree\Shop\OrderManager\Order\Entity\OrderItemEntityInterface;

class MockOrderItemEntity implements OrderItemEntityInterface
{
    public function __construct(private readonly string $orderId, private readonly string $productId, private readonly int $quantity)
    {
        if ('ORDER_ERROR' === $productId) {
            throw new CreateOrderException("ORDER_ERROR");
        }
    }

    public function getOrderId(): string
    {
        return $this->orderId;
    }

    public function getProductId(): string
    {
        return $this->productId;
    }

    public function getQuantity(): int
    {
        return $this->quantity;
    }
}
