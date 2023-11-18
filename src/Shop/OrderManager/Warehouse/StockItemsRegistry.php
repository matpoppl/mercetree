<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

class StockItemsRegistry implements StockItemsRegistryInterface
{
    /**
     * @var StockItemInterface[]
     */
    private array $decreased = [];

    /**
     * @var StockItemInterface[]
     */
    private array $increased = [];

    public function addDecreased(StockItemInterface $item) : void
    {
        $this->decreased[] = $item;
    }

    /**
     * @return StockItemInterface[]
     */
    public function getDecreased() : array
    {
        return $this->decreased;
    }

    public function addIncreased(StockItemInterface $item) : void
    {
        $this->increased[] = $item;
    }

    /**
     * @return StockItemInterface[]
     */
    public function getIncreased() : array
    {
        return $this->increased;
    }
}
