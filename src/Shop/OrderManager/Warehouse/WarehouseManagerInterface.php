<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

interface WarehouseManagerInterface
{
    /**
     * @param StockItemInterface[] $items
     * @throws WarehouseExceptionInterface
     */
    public function transactionBegin(array $items): bool;

    /**
     * @param StockItemInterface[] $items
     * @throws WarehouseExceptionInterface
     */
    public function transactionRollback(array $items): bool;

    /**
     * @param StockItemInterface[] $items
     * @throws WarehouseExceptionInterface
     */
    public function decreaseStock(array $items): bool;

    /**
     * @throws WarehouseExceptionInterface
     */
    public function transactionCommit(): bool;
}
