<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

use Psr\Container\NotFoundExceptionInterface;

interface WarehouseRepositoryManagerInterface
{
    /**
     * @throws NotFoundExceptionInterface
     */
    public function get(string $id) : WarehouseRepositoryInterface;
}
