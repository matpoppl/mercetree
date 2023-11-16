<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Handler;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseRepositoryManagerInterface;
use Psr\Container\ContainerInterface;

class RepositoryCloseHandlerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $repos = $container->get(WarehouseRepositoryManagerInterface::class);
        return new $requestedName($repos);
    }
}
