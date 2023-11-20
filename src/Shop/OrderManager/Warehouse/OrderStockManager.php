<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

use Mateusz\Mercetree\EntityManager\Repository\RepositoryExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseReadRepositoryInterface;

class OrderStockManager implements OrderStockManagerInterface
{
    public function __construct(private readonly WarehouseReadRepositoryInterface $repository)
    {
    }

    /**
     * @throws OrderStockManagerExceptionInterface
     */
    public function decreaseStock(array $items) : array
    {
        try {
            if (! $this->repository->transactionBegin()) {
                throw new OrderStockManagerException("Transaction begin error");
            }

            foreach ($items as $item) {
                if (! $this->repository->lockStockItem($item->getStockItemId(), $item->getQuantity())) {
                    throw new OrderStockManagerException("Transaction lock error");
                }
            }

            $decreased = [];

            foreach ($items as $item) {
                if (! $this->repository->decreaseStock($item->getStockItemId(), $item->getQuantity())) {
                    throw new OrderStockManagerException("Transaction lock error");
                }

                $decreased[] = $item;
            }

            return $decreased;

        } catch (RepositoryExceptionInterface $exception) {
        }

        try {
            $this->repository->transactionRollback();
        } catch (RepositoryExceptionInterface $rollbackException) {
            throw new OrderStockManagerException("Repository rollback error", 0, $rollbackException);
        }

        throw new OrderStockManagerException("Repository error", 0, $exception);
    }

    /**
     * @throws OrderStockManagerExceptionInterface
     */
    public function confirmDecrease() : bool
    {
        try {
            return $this->repository->transactionCommit();
        } catch (RepositoryExceptionInterface $rollbackException) {
            throw new OrderStockManagerException("Repository rollback error", 0, $rollbackException);
        }
    }

    /**
     * @throws OrderStockManagerExceptionInterface
     */
    public function cancelDecrease() : void
    {
        try {
            $this->repository->transactionRollback();
        } catch (RepositoryExceptionInterface $rollbackException) {
            throw new OrderStockManagerException("Repository rollback error", 0, $rollbackException);
        }
    }
}
