<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Handler;

use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\CommandException;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\CommandInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\DecreaseStockItemsCommand;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseWriteRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemsRegistry;

class DecreaseStockItemsHandler implements HandlerInterface
{
    /**
     * @param array<string, WarehouseWriteRepositoryInterface> $repositories
     * @param StockItemsRegistry $stockItemsRegistry
     */
    public function __construct(private readonly array $repositories, private readonly StockItemsRegistry $stockItemsRegistry)
    {
    }

    public function __invoke(CommandInterface $command) : void
    {
        if (! $command instanceof DecreaseStockItemsCommand) {
            throw new CommandException($command,"Unsupported command type");
        }

        $repoId = $command->getRepositoryId();
        $repository = $this->repositories[$repoId] ?? null;

        if (! $repository) {
            throw new CommandException($command,"Repository `{$repoId}` not found");
        }

        foreach ($command->getStockItems() as $item) {
            if (! $repository->decreaseStock($item->getStockItemId(), $item->getQuantity()) ) {
                throw new CommandException($command,"Repository `{$repoId}` decrease error");
            }
            $this->stockItemsRegistry->addDecreased($repoId, $item);
        }
    }
}
