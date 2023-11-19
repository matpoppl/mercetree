<?php

namespace Mateusz\Mercetree\Shop\OrderManager\CreateOrder;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Psr\EventDispatcher\EventDispatcherInterface;
use Psr\Log\LoggerInterface;

class CreateOrderServiceFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new $requestedName(
            $container->get(CreateOrderManagerInterface::class),
            $container->get(EventDispatcherInterface::class),
            $container->get(LoggerInterface::class)
        );
    }
}
