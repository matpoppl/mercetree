<?php

namespace Mateusz\Mercetree\Shop\OrderManager;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderManagerInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\WarehouseManagerInterface;
use Psr\Container\ContainerInterface;

class CreateOrderFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $warehouseManager = $container->get(WarehouseManagerInterface::class);
        $createOrderManager = $container->get(CreateOrderManagerInterface::class);
        return new $requestedName($warehouseManager, $createOrderManager);
    }
}
