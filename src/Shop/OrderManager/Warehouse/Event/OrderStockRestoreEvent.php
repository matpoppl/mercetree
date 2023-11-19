<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Event;

use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestItemInterface;

class OrderStockRestoreEvent
{
    /**
     * @param string $requestId
     * @param OrderRequestItemInterface[] $items
     */
    public function __construct(private readonly string $requestId, private readonly array $items)
    {
    }

    public function getRequestId() : string
    {
        return $this->requestId;
    }

    /**
     * @return OrderRequestItemInterface[]
     */
    public function getItems() : array
    {
        return $this->items;
    }
}
