<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Event;

use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;

class OrderRequestAcceptedEvent
{
    public function __construct(private readonly OrderRequestInterface $request)
    {
    }

    public function getOrderRequest() : OrderRequestInterface
    {
        return $this->request;
    }
}
