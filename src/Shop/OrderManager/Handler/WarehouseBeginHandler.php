<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Handler;

use Mateusz\Mercetree\Shop\OrderManager\Command\WarehouseSubmitCommand;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandException;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandInterface;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\HandlerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\WarehouseExceptionInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\WarehouseManagerInterface;

class WarehouseBeginHandler implements HandlerInterface
{
    public function __construct(private readonly WarehouseManagerInterface $warehouseManager)
    {
    }

    public function __invoke(CommandInterface $command): void
    {
        if (! $command instanceof WarehouseSubmitCommand) {
            throw new CommandException($command,"Unsupported command type");
        }

        try {
            $this->warehouseManager->begin($command->getStockItems());
        } catch (WarehouseExceptionInterface $e) {
            throw new CommandException($command, 'Warehouse manager submit error', 0, $e);
        }
    }
}
