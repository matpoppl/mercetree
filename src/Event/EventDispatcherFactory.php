<?php

namespace Mateusz\Mercetree\Event;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class EventDispatcherFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new $requestedName($container->get(ListenerProviderInterface::class), $container->get(LoggerInterface::class));
    }
}
