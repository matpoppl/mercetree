<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Handler;

use Mateusz\Mercetree\Shop\OrderManager\Command\CreateOrderSubmitCommand;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandException;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandInterface;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\HandlerInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderManagerInterface;

class CreateOrderSubmitHandler implements HandlerInterface
{
    public function __construct(private readonly CreateOrderManagerInterface $createOrderManager)
    {
    }

    public function __invoke(CommandInterface $command): void
    {
        if (! $command instanceof CreateOrderSubmitCommand) {
            throw new CommandException($command,"Unsupported command type");
        }
        
        try {
            $ok = $this->createOrderManager->transactionBegin();
            $exception = null;
        } catch (CreateOrderExceptionInterface $exception) {
            $ok = false;
        }
        
        if (! $ok) {
            throw new CommandException($command, 'Warehouse manager submit error', 0, $exception);
        }
        
        try {
            $order = $this->createOrderManager->createOrder($command->getOrderRequest());
            $items = $this->createOrderManager->createOrderItems($order, $command->getOrderRequest());

            $command->setOrderEntity($order);
            $command->setOrderItemEntities($items);
        } catch (CreateOrderExceptionInterface $e) {
            throw new CommandException($command, 'Warehouse manager submit error', 0, $e);
        }
    }
}
