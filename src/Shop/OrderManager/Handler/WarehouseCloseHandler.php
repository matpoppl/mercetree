<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Handler;

use Mateusz\Mercetree\Shop\OrderManager\Command\TransactionCloseEnum;
use Mateusz\Mercetree\Shop\OrderManager\Command\WarehouseCloseCommand;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandException;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandInterface;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\HandlerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\WarehouseExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\WarehouseManagerInterface;

class WarehouseCloseHandler implements HandlerInterface
{
    public function __construct(private readonly WarehouseManagerInterface $warehouseManager)
    {
    }

    public function __invoke(CommandInterface $command): void
    {
        if (! $command instanceof WarehouseCloseCommand) {
            throw new CommandException($command,"Unsupported command type");
        }

        try {
            
            $ok = match ($command->getTransactionClose()) {
                TransactionCloseEnum::COMMIT => $this->warehouseManager->commit(),
                TransactionCloseEnum::ROLLBACK => $this->warehouseManager->rollback(),
                default => throw new CommandException($command, 'Unsupported TransactionClose type')
            };
            $exception = null;
        } catch (WarehouseExceptionInterface $exception) {
            $ok = false;
        }
        
        if (! $ok) {
            throw new CommandException($command, 'WarehouseManager close error', 0, $exception);
        }
    }
}
