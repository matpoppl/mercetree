<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Handler;

use Mateusz\Mercetree\Shop\OrderManager\Command\CreateOrderCloseCommand;
use Mateusz\Mercetree\Shop\OrderManager\Command\TransactionCloseEnum;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandException;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandInterface;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\HandlerInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderManagerInterface;

class CreateOrderCloseHandler implements HandlerInterface
{
    public function __construct(private readonly CreateOrderManagerInterface $createOrderManager)
    {
    }

    public function __invoke(CommandInterface $command): void
    {
        if (! $command instanceof CreateOrderCloseCommand) {
            throw new CommandException($command,"Unsupported command type");
        }

        try {

            switch ($command->getTransactionClose()) {
                case TransactionCloseEnum::COMMIT:
                    $this->createOrderManager->transactionCommit();
                    break;
                case TransactionCloseEnum::ROLLBACK:
                    $this->createOrderManager->transactionRollback();
                    break;
                default:
                    throw new CommandException($command, 'Unsupported TransactionClose');
            }

        } catch (CreateOrderExceptionInterface $e) {
            throw new CommandException($command, 'Warehouse manager submit error', 0, $e);
        }
    }
}
