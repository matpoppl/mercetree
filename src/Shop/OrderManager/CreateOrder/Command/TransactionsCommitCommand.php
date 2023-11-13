<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Command;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderManagerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\WarehouseExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\WarehouseManagerInterface;

class TransactionsCommitCommand extends AbstractTransactionCommand
{
    public function __construct(private readonly CreateOrderManagerInterface $createOrderManager, private readonly WarehouseManagerInterface $warehouseManager)
    {
    }

    public function execute() : bool
    {
        $this->exceptions = [];

        try {
            if (! $this->warehouseManager->transactionCommit()) {
                return false;
            }
        } catch (WarehouseExceptionInterface $e) {
            $this->exceptions[] = $e;
            return false;
        }

        try {
            return $this->createOrderManager->transactionCommit();
        } catch (CreateOrderExceptionInterface $e) {
            $this->exceptions[] = $e;
        }

        return false;
    }
}
