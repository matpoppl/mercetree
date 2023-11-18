<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Event;

use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;
use Throwable;

class CreateOrderEvent implements CreateOrderEventInterface
{
    private bool $propagationStopped = false;
    private ?Throwable $stopReason = null; // ? ReasonType ?

    public function __construct(private readonly CreateOrderStepEnum $step, private readonly OrderRequestInterface $request)
    {
    }

    public function getOrderRequest() : OrderRequestInterface
    {
        return $this->request;
    }

    public function getCurrentStep() : CreateOrderStepEnum
    {
        return $this->step;
    }

    public function stopPropagation(Throwable $reason): void
    {
        $this->stopReason = $reason;
        $this->propagationStopped = true;
    }

    public function isPropagationStopped(): bool
    {
        return $this->propagationStopped;
    }

    public function getStopReason(): ?Throwable
    {
        return $this->stopReason;
    }
}
