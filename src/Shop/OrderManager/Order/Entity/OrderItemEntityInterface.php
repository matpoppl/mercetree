<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Order\Entity;

interface OrderItemEntityInterface
{
    public function getOrderId() : string;
    public function getProductId() : string;
    public function getQuantity() : int;
}
