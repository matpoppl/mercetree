<?php

namespace Mateusz\Mercetree\Shop\OrderManager\Order\Request;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class RequestStatusManagerListenerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new $requestedName($container->get(RequestStatusManagerInterface::class));
    }
}
