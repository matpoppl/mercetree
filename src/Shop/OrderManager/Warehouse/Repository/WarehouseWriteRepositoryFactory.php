<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemsRegistry;

class WarehouseWriteRepositoryFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new $requestedName(new MockWriteAdapter(), $container->get(StockItemsRegistry::class));
    }
}
