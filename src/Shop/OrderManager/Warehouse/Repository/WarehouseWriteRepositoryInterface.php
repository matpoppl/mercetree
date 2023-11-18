<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

use Mateusz\Mercetree\EntityManager\Repository\RepositoryExceptionInterface;

interface WarehouseWriteRepositoryInterface
{
    /**
     * @throws RepositoryExceptionInterface
     */
    public function decreaseStock(string $itemId, int $quantity) : bool;

    /**
     * @throws RepositoryExceptionInterface
     */
    public function increaseStock(string $itemId, int $quantity) : bool;
}
