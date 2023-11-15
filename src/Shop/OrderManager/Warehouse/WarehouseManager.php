<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandBusInterface;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\TransactionStatusEnum;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class WarehouseManager implements WarehouseManagerInterface
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
        $this->commandBus->subscribe(Command\TransactionCommand::class, Handler\TransactionHandler::class);
        $this->commandBus->subscribe(Command\LockStockItemsCommand::class, Handler\LockStockItemsHandler::class);
        $this->commandBus->subscribe(Command\DecreaseStockItemsCommand::class, Handler\DecreaseStockItemsHandler::class);
        $this->commandBus->subscribe(Command\IncreaseStockItemsCommand::class, Handler\IncreaseStockItemsHandler::class);
    }

    /**
     * @throws WarehouseExceptionInterface
     */
    public function begin(array $items) : void
    {
        try {
            $this->commandBus->dispatch(new Command\TransactionCommand(TransactionStatusEnum::BEGIN));
            $this->commandBus->dispatch(new Command\LockStockItemsCommand($items));
            $this->commandBus->dispatch(new Command\DecreaseStockItemsCommand('read', $items));
            $this->commandBus->dispatch(new Command\DecreaseStockItemsCommand('write', $items));
        } catch (CommandExceptionInterface $exception) {
            throw new WarehouseException("WarehouseManager submit command error", 0 , $exception);
        } catch (ContainerExceptionInterface|NotFoundExceptionInterface $exception) {
            throw new WarehouseException("WarehouseManager submit command service container error", 0 , $exception);
        }
    }

    /**
     * @throws WarehouseExceptionInterface
     */
    public function commit() : void
    {
        try {
            $this->commandBus->dispatch(new Command\TransactionCommand(TransactionStatusEnum::COMMIT));
        } catch (CommandExceptionInterface $exception) {
            throw new WarehouseException("WarehouseManager submit command error", 0 , $exception);
        } catch (ContainerExceptionInterface|NotFoundExceptionInterface $exception) {
            throw new WarehouseException("WarehouseManager submit command service container error", 0 , $exception);
        }
    }

    /**
     * @throws WarehouseExceptionInterface
     */
    public function rollback() : void
    {
        $commands = [
            new Command\IncreaseStockItemsCommand('write'),
            new Command\TransactionCommand(TransactionStatusEnum::ROLLBACK)
        ];

        $exceptions = [];

        foreach ($commands as $command) {
            try {
                $this->commandBus->dispatch($command);
            } catch (CommandExceptionInterface $exception) {
                $exceptions[] = new WarehouseException("Increase stock error", 0 , $exception);
            } catch (ContainerExceptionInterface|NotFoundExceptionInterface $exception) {
                $exceptions[] = new WarehouseException("Increase stock service container error", 0 , $exception);
            }
        }

        foreach ($exceptions as $exception) {
            throw $exception;
        }
    }
}
