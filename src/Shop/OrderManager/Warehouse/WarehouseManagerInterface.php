<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

interface WarehouseManagerInterface
{
    /**
     * @throws WarehouseExceptionInterface
     */
    public function begin(array $items) : void;

    /**
     * @throws WarehouseExceptionInterface
     */
    public function commit() : void;

    /**
     * @throws WarehouseExceptionInterface
     */
    public function rollback() : void;
}
