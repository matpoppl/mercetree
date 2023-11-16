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
            
            switch ($command->getTransactionClose()) {
                case TransactionCloseEnum::COMMIT:
                    $this->warehouseManager->commit();
                    break;
                case TransactionCloseEnum::ROLLBACK:
                    $this->warehouseManager->rollback();
                    break;
                default:
                    throw new CommandException($command, 'Unsupported TransactionClose operation');
            }


        } catch (WarehouseExceptionInterface $e) {
            throw new CommandException($command, 'Warehouse manager rollback error', 0, $e);
        }
    }
}
