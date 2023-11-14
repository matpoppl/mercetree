<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Command;

class IncreaseStockItemsCommand implements CommandInterface
{
    public function __construct(public readonly string $repoId)
    {
    }

    public function getRepositoryId() : string
    {
        return $this->repoId;
    }
}
