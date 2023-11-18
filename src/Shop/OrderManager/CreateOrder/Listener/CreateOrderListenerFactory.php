<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Listener;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderManagerInterface;
use Psr\Container\ContainerInterface;

class CreateOrderListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new $requestedName($container->get(CreateOrderManagerInterface::class));
    }
}
