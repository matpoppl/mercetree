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
            
            $ok = match ($command->getTransactionClose()) {
                TransactionCloseEnum::COMMIT => $this->createOrderManager->transactionCommit(),
                TransactionCloseEnum::ROLLBACK => $this->createOrderManager->transactionRollback(),
                default => throw new CommandException($command, 'Unsupported TransactionClose type')
            };
            $exception = null;
        } catch (CreateOrderExceptionInterface $exception) {
            $ok = false;
        }
        
        if (! $ok) {
            throw new CommandException($command, 'CreateOrder close error', 0, $exception);
        }
    }
}
