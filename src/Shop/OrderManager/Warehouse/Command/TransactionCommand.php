<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command;

use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandInterface;

class TransactionCommand implements CommandInterface
{
    public function __construct(private readonly TransactionStatusEnum $status)
    {
    }

    public function getStatus() : TransactionStatusEnum
    {
        return $this->status;
    }
}
