<?php

namespace Mateusz\Mercetree\Application\Component;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Psr\Container\ContainerInterface;

class MockComponentServiceFactory implements FactoryInterface
{

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $options ??= $container->get(ConfigInterface::class)->get($requestedName);
        return new $requestedName($options);
    }
}
