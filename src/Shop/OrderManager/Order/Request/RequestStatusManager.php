<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Order\Request;

class RequestStatusManager implements RequestStatusManagerInterface
{
    private array $statuses = [];

    public function createRequestStatus(string $requestId) : RequestStatusInterface
    {
        return $this->statuses[$requestId] = new RequestStatus();
    }

    public function getOrderRequestStatus(string $requestId) : ?RequestStatusInterface
    {
        return $this->statuses[$requestId] ?? null;
    }
}
