<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Event;

use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;
use Psr\EventDispatcher\StoppableEventInterface;
use Throwable;

interface CreateOrderEventInterface extends StoppableEventInterface
{
    public function stopPropagation(Throwable $reason): void;

    public function getCurrentStep() : CreateOrderStepEnum;

    public function getOrderRequest() : OrderRequestInterface;
}
