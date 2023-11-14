<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

class MockReadAdapter
{
    public function readStockQuantity(string $itemId) : int
    {
        echo '[DEBUG] ' . __METHOD__ . "({$itemId})\n";
        return 0;
    }

    public function transactionBegin(): bool
    {
        echo '[DEBUG] ' . __METHOD__ . "()\n";
        return true;
    }

    public function transactionRollback(): bool
    {
        echo '[DEBUG] ' . __METHOD__ . "()\n";
        return true;
    }

    public function transactionCommit(): bool
    {
        echo '[DEBUG] ' . __METHOD__ . "()\n";
        return true;
    }

    public function lockStockItem(string $itemId, int $quantity): bool
    {
        if ('READ_OUT_OF_STOCK' === $itemId) {
            echo '[OUT_OF_STOCK] ' . __METHOD__ . "({$itemId},{$quantity}) !! OUT_OF_STOCK !!\n";
            return false;
        }
        echo '[DEBUG] ' . __METHOD__ . "({$itemId},{$quantity})\n";
        return true;
    }

    public function decreaseStock(string $itemId, int $quantity): bool
    {
        echo '[DEBUG] ' . __METHOD__ . "({$itemId},{$quantity})\n";
        return true;
    }

    public function increaseStock(string $itemId, int $quantity): bool
    {
        echo '[DEBUG] ' . __METHOD__ . "({$itemId},{$quantity})\n";
        return true;
    }
}
