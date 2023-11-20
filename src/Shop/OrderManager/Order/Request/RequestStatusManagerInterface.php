<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Order\Request;

interface RequestStatusManagerInterface
{
    public function createRequestStatus(string $requestId) : RequestStatusInterface;

    public function getOrderRequestStatus(string $requestId) : ?RequestStatusInterface;
}
