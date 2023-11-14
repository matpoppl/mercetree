<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Handler;

use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\CommandException;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\CommandInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\LockStockItemsCommand;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseReadRepositoryInterface;

class LockStockItemsHandler implements HandlerInterface
{
    public function __construct(private readonly WarehouseReadRepositoryInterface $repository)
    {
    }

    public function __invoke(CommandInterface $command) : void
    {
        if (! $command instanceof LockStockItemsCommand) {
            throw new CommandException($command,"Unsupported command type");
        }

        foreach ($command->getStockItems() as $item) {
            if (! $this->repository->lockStockItem($item->getStockItemId(), $item->getQuantity()) ) {
                throw new CommandException($command,"Repository  lock error");
            }
        }
    }
}
