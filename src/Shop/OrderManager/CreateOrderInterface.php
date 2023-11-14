<?php

namespace Mateusz\Mercetree\Shop\OrderManager;

use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreatedOrderInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;

interface CreateOrderInterface
{

    /**
     * @throws OrderManagerExceptionInterface
     */
    public function create(OrderRequestInterface $request) : ?CreatedOrderInterface;
}