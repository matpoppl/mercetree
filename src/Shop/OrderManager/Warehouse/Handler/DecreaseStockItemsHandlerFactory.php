<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Handler;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseReadRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseWriteRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemsRegistry;
use Psr\Container\ContainerInterface;

class DecreaseStockItemsHandlerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $repos = [
            'read' => $container->get(WarehouseReadRepositoryInterface::class),
            'write' => $container->get(WarehouseWriteRepositoryInterface::class),
        ];

        return new $requestedName($repos, $container->get(StockItemsRegistry::class));
    }
}
