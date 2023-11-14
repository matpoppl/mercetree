<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Command;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderManagerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\WarehouseExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\WarehouseManagerInterface;

class TransactionsRollbackCommand extends AbstractTransactionCommand
{
    /**
     * @param CreateOrderManagerInterface $createOrderManager
     * @param WarehouseManagerInterface $warehouseManager
     * @param StockItemInterface[] $items
     */
    public function __construct(private readonly CreateOrderManagerInterface $createOrderManager, private readonly WarehouseManagerInterface $warehouseManager, private readonly array $items)
    {
    }

    public function execute() : bool
    {
        $this->exceptions = [];

        $success = 0;

        try {
            $success += $this->warehouseManager->transactionRollback($this->items) ? 1 : 0;
        } catch (WarehouseExceptionInterface $e) {
            $this->exceptions[] = $e;
        }

        try {
            $success += $this->createOrderManager->transactionRollback();
        } catch (CreateOrderExceptionInterface $e) {
            $this->exceptions[] = $e;
        }

        return $success > 1;
    }
}
