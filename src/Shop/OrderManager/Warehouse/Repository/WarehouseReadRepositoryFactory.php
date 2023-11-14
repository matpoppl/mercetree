<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class WarehouseReadRepositoryFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new $requestedName(new MockReadAdapter());
    }
}
