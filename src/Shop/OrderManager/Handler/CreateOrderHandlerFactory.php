<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Handler;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\CreateOrderManagerInterface;
use Psr\Container\ContainerInterface;

class CreateOrderHandlerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new $requestedName($container->get(CreateOrderManagerInterface::class));
    }
}
