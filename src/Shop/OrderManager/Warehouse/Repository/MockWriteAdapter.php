<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

class MockWriteAdapter
{
    public function __construct()
    {
    }

    public function decreaseStock(string $itemId, int $quantity) : bool
    {
        if ('WRITE_OUT_OF_STOCK' === $itemId) {
            echo '[OUT_OF_STOCK] ' . __METHOD__ . "({$itemId},{$quantity}) !! OUT_OF_STOCK !!\n";
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
