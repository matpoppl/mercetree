<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Handler;

use Mateusz\Mercetree\EntityManager\Repository\RepositoryExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandException;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandInterface;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\HandlerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\TransactionCommand;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\TransactionStatusEnum;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseReadRepositoryInterface;

class TransactionHandler implements HandlerInterface
{
    public function __construct(private readonly WarehouseReadRepositoryInterface $readRepository)
    {
    }

    /**
     * @throws CommandException
     */
    public function __invoke(CommandInterface $command) : void
    {
        if (! $command instanceof TransactionCommand) {
            throw new CommandException($command,"Unsupported command type");
        }

        try {

            $ok = match($command->getStatus()) {
                TransactionStatusEnum::BEGIN => $this->readRepository->transactionBegin(),
                TransactionStatusEnum::COMMIT => $this->readRepository->transactionCommit(),
                TransactionStatusEnum::ROLLBACK => $this->readRepository->transactionRollback(),
                default => throw new CommandException($command,"WriteRepository transaction begin error"),
            };

            $ex = null;

        } catch (RepositoryExceptionInterface $ex) {
            $ok = false;
        }

        if (! $ok) {
            throw new CommandException($command,"WriteRepository transaction begin error", 0, $ex);
        }
    }
}
