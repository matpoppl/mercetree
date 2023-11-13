<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Order\Request;

use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemInterface;

interface OrderRequestItemInterface extends StockItemInterface
{
    public function getQuantity() : int;
}
