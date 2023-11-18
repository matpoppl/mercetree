<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

interface StockItemsRegistryInterface
{
    public function addDecreased(StockItemInterface $item) : void;

    /**
     * @return StockItemInterface[]
     */
    public function getDecreased() : array;

    public function addIncreased(StockItemInterface $item) : void;

    /**
     * @return StockItemInterface[]
     */
    public function getIncreased() : array;
}
