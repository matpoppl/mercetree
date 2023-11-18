<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Warehouse\Listener\ReadRepository;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository\WarehouseReadRepositoryInterface;
use Psr\Container\ContainerInterface;

class CreateOrderListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new $requestedName($container->get(WarehouseReadRepositoryInterface::class));
    }
}
