<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Event;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\Event\EventDispatcher;
use Mateusz\Mercetree\Event\ListenerProviderInterface;
use Psr\Container\ContainerInterface;
use Psr\Log\LoggerInterface;

class CreateOrderEventManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $listenerProvider = $container->get(ListenerProviderInterface::class);
        $logger = $container->get(LoggerInterface::class);;
        $eventDispatcher = new EventDispatcher($listenerProvider, $logger);
        return new $requestedName($listenerProvider, $eventDispatcher);
    }
}
