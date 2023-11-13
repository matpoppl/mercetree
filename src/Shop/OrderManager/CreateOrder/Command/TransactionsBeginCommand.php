<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Command;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderManagerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\WarehouseExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\WarehouseManagerInterface;

class TransactionsBeginCommand extends AbstractTransactionCommand
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

        try {
            if (! $this->warehouseManager->transactionBegin($this->items)) {
                return false;
            }

            if (! $this->warehouseManager->decreaseStock($this->items)) {
                return false;
            }
        } catch (WarehouseExceptionInterface $e) {
            $this->exceptions[] = $e;
        }

        try {
            return $this->createOrderManager->transactionBegin();
        } catch (CreateOrderExceptionInterface $e) {
            $this->exceptions[] = $e;
        }

        return false;
    }
}
