<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Listener;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderServiceInterface;
use Psr\Container\ContainerInterface;

class OrderRequestCreatedListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new $requestedName($container->get(CreateOrderServiceInterface::class));
    }
}
