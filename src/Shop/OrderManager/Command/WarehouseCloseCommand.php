<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Command;

use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandInterface;

class WarehouseCloseCommand implements CommandInterface
{
    public function __construct(private readonly TransactionCloseEnum $transactionClose)
    {
    }

    public function getTransactionClose() : TransactionCloseEnum
    {
        return $this->transactionClose;
    }
}
