<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

class MockWriteAdapter
{
    public function __construct()
    {
    }

    public function decreaseStock(string $itemId, int $quantity) : bool
    {
        if ('WRITE_ERROR' === $itemId) {
            echo '[WRITE_ERROR] ' . __METHOD__ . "({$itemId},{$quantity}) !! WRITE_ERROR !!\n";
            return false;
        }
        echo '[DEBUG] ' . __METHOD__ . "({$itemId}, {$quantity})\n";
        return true;
    }

    public function increaseStock(string $itemId, int $quantity) : bool
    {
        echo '[DEBUG] ' . __METHOD__ . "({$itemId}, {$quantity})\n";
        return true;
    }
}
