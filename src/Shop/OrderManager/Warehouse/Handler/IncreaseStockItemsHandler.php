<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Handler;

use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\CommandException;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\CommandInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command\IncreaseStockItemsCommand;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseWriteRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemsRegistry;

class IncreaseStockItemsHandler implements HandlerInterface
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
        if (! $command instanceof IncreaseStockItemsCommand) {
            throw new CommandException($command,"Unsupported command type");
        }

        $repoId = $command->getRepositoryId();
        $repository = $this->repositories[$repoId] ?? null;

        if (! $repository) {
            throw new \UnexpectedValueException("Repository `{$repoId}` not found");
        }

        foreach ($this->stockItemsRegistry->getDecreased($repoId) as $item) {
            if (! $repository->increaseStock($item->getStockItemId(), $item->getQuantity()) ) {
                throw new CommandException($command,"Repository `{$repoId}` increase error");
            }
            $this->stockItemsRegistry->addIncreased($repoId, $item);
        }
    }
}
