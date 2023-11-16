<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandBusInterface;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandExceptionInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseReadRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseWriteRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\RepositoryCloseEnum;

class WarehouseManager implements WarehouseManagerInterface
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
        $this->commandBus->subscribe(Command\RepositoryBeginCommand::class, Handler\RepositoryBeginHandler::class);
        $this->commandBus->subscribe(Command\RepositoryCloseCommand::class, Handler\RepositoryCloseHandler::class);
    }

    /**
     * @throws WarehouseExceptionInterface
     */
    public function begin(array $items) : bool
    {
        try {
            $this->commandBus->dispatch(new Command\RepositoryBeginCommand(WarehouseReadRepositoryInterface::class, $items));
            $this->commandBus->dispatch(new Command\RepositoryBeginCommand(WarehouseWriteRepositoryInterface::class, $items));
            
            return true;
        } catch (CommandExceptionInterface $exception) {
            throw new WarehouseException("WarehouseManager submit command error", 0 , $exception);
        } catch (ContainerExceptionInterface|NotFoundExceptionInterface $exception) {
            throw new WarehouseException("WarehouseManager submit command service container error", 0 , $exception);
        }
    }

    /**
     * @throws WarehouseExceptionInterface
     */
    public function commit() : bool
    {
        try {
            $this->commandBus->dispatch(new Command\RepositoryCloseCommand(WarehouseWriteRepositoryInterface::class, RepositoryCloseEnum::COMMIT));
            $this->commandBus->dispatch(new Command\RepositoryCloseCommand(WarehouseReadRepositoryInterface::class, RepositoryCloseEnum::COMMIT));
            
            return true;
        } catch (CommandExceptionInterface $exception) {
            throw new WarehouseException("WarehouseManager submit command error", 0 , $exception);
        } catch (ContainerExceptionInterface|NotFoundExceptionInterface $exception) {
            throw new WarehouseException("WarehouseManager submit command service container error", 0 , $exception);
        }
    }

    /**
     * @throws WarehouseExceptionInterface
     */
    public function rollback() : bool
    {
        $commands = [
            new Command\RepositoryCloseCommand(WarehouseReadRepositoryInterface::class, RepositoryCloseEnum::ROLLBACK),
            new Command\RepositoryCloseCommand(WarehouseWriteRepositoryInterface::class, RepositoryCloseEnum::ROLLBACK),
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
        
        return true;
    }
}
