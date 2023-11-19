<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Order\Request;

interface RequestStatusManagerInterface
{
    public function createRequestStatus(string $requestId) : void;

    public function getOrderRequestStatus(string $requestId) : ?RequestStatusInterface;
}
