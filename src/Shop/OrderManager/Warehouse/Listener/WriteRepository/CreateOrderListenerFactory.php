<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Listener\WriteRepository;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseWriteRepositoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\StockItemsRegistryInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class CreateOrderListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new $requestedName(
            $container->get(WarehouseWriteRepositoryInterface::class),
            $container->get(StockItemsRegistryInterface::class),
            $container->get(LoggerInterface::class)
        );
    }
}
