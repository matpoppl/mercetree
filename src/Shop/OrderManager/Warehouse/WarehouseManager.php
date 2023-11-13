<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

use Mateusz\Mercetree\EntityManager\Repository\RepositoryExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\CommandInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\DecreaseStockItemsCommand;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\HasStockItemsCommand;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\IncreaseStockItemsCommand;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\LockStockItemsCommand;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\UnlockStockItemsCommand;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseLockItemRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseReadRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseWriteRepositoryInterface;

class WarehouseManager implements WarehouseManagerInterface
{
    public function __construct(private readonly WarehouseReadRepositoryInterface $readRepository, private readonly WarehouseWriteRepositoryInterface $writeRepository)
    {
    }

    /**
     * @throws WarehouseExceptionInterface
     */
    public function lock(WarehouseLockItemRepositoryInterface $repository, array $items) : bool
    {
        $cmd = new LockStockItemsCommand($repository, $items);

        if ($cmd->execute()) {
            return true;
        }

        // auto unlock
        $this->unlock($repository, $cmd->getLocked());

        return false;
    }

    /**
     * @throws WarehouseExceptionInterface
     */
    public function unlock(WarehouseLockItemRepositoryInterface $repository, array $items) : bool
    {
        return $this->runCommand(new UnlockStockItemsCommand($repository, $items), "Unlocking items in warehouse error");
    }

    /**
     * @throws WarehouseException
     */
    public function runCommand(CommandInterface $cmd, string $exceptionMessage) : bool
    {
        if ($cmd->execute()) {
            return true;
        }

        throw WarehouseException::commandException($cmd, $exceptionMessage);
    }

    public function transactionBegin(array $items) : bool
    {
        try {
            if (! $this->writeRepository->transactionBegin()) {
                return false;
            }
        } catch (RepositoryExceptionInterface $ex) {
            throw new WarehouseException("WriteRepository transaction begin error", 0 ,$ex);
        }

        if ($this->lock($this->readRepository, $items)) {
            return true;
        }

        // auto rollback
        $this->transactionRollback($items);

        return false;
    }

    public function transactionRollback(array $items) : bool
    {
        $exceptions = [];

        $success = 0;

        try {
            $success += $this->writeRepository->transactionRollback() ? 1 : 0;
        } catch (RepositoryExceptionInterface $exception) {
            $exceptions[] = $exception;
        }

        try {
            $success += $this->unlock($this->readRepository, $items) ? 1 : 0;
        } catch (WarehouseExceptionInterface $exception) {
            $exceptions[] = $exception;
        }

        foreach ($exceptions as $exception) {
            throw new WarehouseException("Transaction rollback error", 0 , $exception);
        }

        return $success > 1;
    }

    public function transactionCommit(): bool
    {
        try {
            return $this->writeRepository->transactionCommit();
        } catch (RepositoryExceptionInterface $exception) {
            throw new WarehouseException("Transaction commit error", 0 , $exception);
        }
    }

    /**
     * @param StockItemInterface[] $items
     * @return StockItemInterface[]
     */
    public function findOutOfStock(array $items): array
    {
        $cmd = new HasStockItemsCommand($this->readRepository, $items);

        if ($cmd->execute()) {
            return [];
        }

        return $cmd->getOutOtStock();
    }

    public function increaseStock(array $items): bool
    {
        return $this->runCommand(new IncreaseStockItemsCommand($this->writeRepository, $items), "Increase stock items error");
    }

    public function decreaseStock(array $items): bool
    {
        return $this->runCommand(new DecreaseStockItemsCommand($this->writeRepository, $items), "Decrease stock items error");
    }
}
