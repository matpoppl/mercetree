<?php

namespace Mateusz\Mercetree\ServiceManager\Config;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\Application\Config\Loader\File\PhpConfigFileLoaderInterface;
use Psr\Container\ContainerInterface;

class ServiceConfigResolverFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new $requestedName(
            $container->get(ConfigInterface::class),
            $container->get(PhpConfigFileLoaderInterface::class)
        );
    }
}
