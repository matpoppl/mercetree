<?php

namespace Mateusz\Mercetree\Shop\OrderManager;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\Shop\OrderManager\CommandBus\CommandBus;
use Psr\Container\ContainerInterface;

class CreateOrderFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $commandBus = new CommandBus($container);
        return new $requestedName($commandBus);
    }
}
