<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

interface WarehouseManagerInterface
{
    /**
     * @throws WarehouseExceptionInterface
     */
    public function begin(array $items) : bool;

    /**
     * @throws WarehouseExceptionInterface
     */
    public function commit() : bool;

    /**
     * @throws WarehouseExceptionInterface
     */
    public function rollback() : bool;
}
