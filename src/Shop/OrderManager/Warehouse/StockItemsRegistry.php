<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

class StockItemsRegistry
{
    /**
     * @var array<string, StockItemInterface[]>
     */
    private array $decreased = [];

    /**
     * @var array<string, StockItemInterface[]>
     */
    private array $increased = [];

    public function addDecreased(string $repoId, StockItemInterface $item) : void
    {
        $this->decreased[$repoId][] = $item;
    }

    /**
     * @return StockItemInterface[]
     */
    public function getDecreased(string $repoId) : array
    {
        return $this->decreased[$repoId] ?? [];
    }

    public function addIncreased(string $repoId, StockItemInterface $item) : void
    {
        $this->increased[$repoId][] = $item;
    }

    /**
     * @return StockItemInterface[]
     */
    public function getIncreased(string $repoId) : array
    {
        return $this->increased[$repoId] ?? [];
    }
}
