<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

interface StockItemInterface
{
    public function getStockItemId() : string;
    public function getQuantity() : int;
}
