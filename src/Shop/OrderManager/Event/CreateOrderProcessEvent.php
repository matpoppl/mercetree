<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Event;

class CreateOrderProcessEvent extends CreateOrderEvent implements CreateOrderProcessEventInterface
{
    private array $data = [];

    public function getProcessedData(string $type) : mixed
    {
        return $this->data[$type] ?? null;
    }

    public function setProcessedData(string $type, mixed $data) : void
    {
        $this->data[$type] = $data;
    }
}
