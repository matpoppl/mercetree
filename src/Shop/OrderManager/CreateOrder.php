<?php

namespace Mateusz\Mercetree\Shop\OrderManager;

use Mateusz\Mercetree\Shop\OrderManager\Command\TransactionCloseEnum;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandBusInterface;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreatedOrderInterface;
use Mateusz\Mercetree\Shop\OrderManager\Order\Request\OrderRequestInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class CreateOrder implements CreateOrderInterface
{
    public function __construct(private readonly CommandBusInterface $commandBus)
    {
        $this->commandBus->subscribe(Command\WarehouseSubmitCommand::class, Handler\WarehouseBeginHandler::class);
        $this->commandBus->subscribe(Command\WarehouseCloseCommand::class, Handler\WarehouseCloseHandler::class);
        $this->commandBus->subscribe(Command\CreateOrderSubmitCommand::class, Handler\CreateOrderSubmitHandler::class);
        $this->commandBus->subscribe(Command\CreateOrderCloseCommand::class, Handler\CreateOrderCloseHandler::class);
    }

    /**
     * @throws OrderManagerExceptionInterface
     */
    public function create(OrderRequestInterface $request) : ?CreatedOrderInterface
    {
        $orderCmd = new Command\CreateOrderSubmitCommand($request);

        $exceptions = [];

        try {
            $this->commandBus->dispatch(new Command\WarehouseSubmitCommand($request->getItems()));
            $this->commandBus->dispatch($orderCmd);
            $this->commandBus->dispatch(new Command\WarehouseCloseCommand(TransactionCloseEnum::COMMIT));
            $this->commandBus->dispatch(new Command\CreateOrderCloseCommand(TransactionCloseEnum::COMMIT));
            return $orderCmd->getCreatedOrder();
        } catch (CommandExceptionInterface $exception) {
            $exceptions[] = new OrderManagerException('CreateOrder submit error', 0,  $exception);
        } catch (NotFoundExceptionInterface|ContainerExceptionInterface $exception) {
            $exceptions[] = new OrderManagerException('CreateOrder submit service container error', 0,  $exception);
        }

        $rollbacks = [
            new Command\WarehouseCloseCommand(TransactionCloseEnum::ROLLBACK),
            // @TODO rollback order only after order begin
            new Command\CreateOrderCloseCommand(TransactionCloseEnum::ROLLBACK),
        ];

        foreach ($rollbacks as $rollback) {
            try {
                $this->commandBus->dispatch($rollback);
            } catch (CommandExceptionInterface $exception) {
                $exceptions[] = new OrderManagerException('CreateOrder rollback error', 0,  $exception);
            } catch (NotFoundExceptionInterface|ContainerExceptionInterface $exception) {
                $exceptions[] = new OrderManagerException('CreateOrder rollback service container error', 0,  $exception);
            }
        }

        foreach ($exceptions as $exception) {
            throw $exception;
        }
    }
}
