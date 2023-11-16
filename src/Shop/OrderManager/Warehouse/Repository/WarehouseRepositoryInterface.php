<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestItemInterface;

interface WarehouseRepositoryInterface
{
    /**
     * @param OrderRequestItemInterface[] $items
     * @throws RepositoryExceptionInterface
     * @return bool
     */
    public function begin(array $items): bool;
    
    /**
     *
     * @throws RepositoryExceptionInterface
     * @return bool
     */
    public function commit(): bool;
    
    /**
     *
     * @throws RepositoryExceptionInterface
     * @return bool
     */
    public function rollback(): bool;
}
