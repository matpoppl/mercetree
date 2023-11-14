<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\CommandBus\CommandBus;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseReadRepositoryInterface;
use Psr\Container\ContainerInterface;

class WarehouseManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $readRepository = $container->get(WarehouseReadRepositoryInterface::class);
        $commandBus = new CommandBus($container);
        return new $requestedName($readRepository, $commandBus);
    }
}
