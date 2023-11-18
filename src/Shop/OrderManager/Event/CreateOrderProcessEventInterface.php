<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Event;

interface CreateOrderProcessEventInterface extends CreateOrderEventInterface
{
    public function getProcessedData(string $type) : mixed;

    public function setProcessedData(string $type, mixed $data) : void;
}
