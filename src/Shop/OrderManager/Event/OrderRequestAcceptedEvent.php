<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Event;

use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;
use Mateusz\Mercetree\Event\AbstractStoppableEvent;

class OrderRequestAcceptedEvent extends AbstractStoppableEvent
{
    public function __construct(private readonly OrderRequestInterface $request)
    {
    }

    public function getOrderRequest() : OrderRequestInterface
    {
        return $this->request;
    }
}
