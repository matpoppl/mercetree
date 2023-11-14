<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

use Mateusz\Mercetree\EntityManager\Repository\RepositoryExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\CommandExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\CommandBus\CommandBusInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseReadRepositoryInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class WarehouseManager implements WarehouseManagerInterface
{
    public function __construct(private readonly WarehouseReadRepositoryInterface $readRepository, private readonly CommandBusInterface $commandBus)
    {
        $this->commandBus->subscribe(Command\DecreaseStockItemsCommand::class, Handler\DecreaseStockItemsHandler::class);
        $this->commandBus->subscribe(Command\IncreaseStockItemsCommand::class, Handler\IncreaseStockItemsHandler::class);
        $this->commandBus->subscribe(Command\LockStockItemsCommand::class, Handler\LockStockItemsHandler::class);
    }

    /**
     * @throws WarehouseException
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function transactionBegin(array $items) : bool
    {
        try {
            if (! $this->readRepository->transactionBegin()) {
                return false;
            }
        } catch (RepositoryExceptionInterface $ex) {
            throw new WarehouseException("WriteRepository transaction begin error", 0 ,$ex);
        }

        try {
            $this->commandBus->dispatch(new Command\LockStockItemsCommand($items));
        } catch (CommandExceptionInterface $ex) {
            throw new WarehouseException("ReadRepository lock error", 0 ,$ex);
        }

        return true;
    }

    public function transactionRollback(array $items) : bool
    {
        $success = 0;
        $exceptions = [];

        try {
            $success += $this->readRepository->transactionRollback() ? 1 : 0;
        } catch (RepositoryExceptionInterface $exception) {
            $exceptions[] = $exception;
        }

        try {
            $this->commandBus->dispatch(new Command\IncreaseStockItemsCommand('write'));
            $success++;
        } catch (CommandExceptionInterface $exception) {
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
            return $this->readRepository->transactionCommit();
        } catch (RepositoryExceptionInterface $exception) {
            throw new WarehouseException("Transaction commit error", 0 , $exception);
        }
    }

    public function decreaseStock(array $items): bool
    {
        try {
            $this->commandBus->dispatch(new Command\DecreaseStockItemsCommand('read', $items));
            $this->commandBus->dispatch(new Command\DecreaseStockItemsCommand('write', $items));
        } catch (CommandExceptionInterface $exception) {
            throw new WarehouseException("Increase stock error", 0 , $exception);
        }
        return true;
    }
}
