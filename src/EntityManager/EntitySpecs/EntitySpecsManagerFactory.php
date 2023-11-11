<?php

namespace Mateusz\Mercetree\EntityManager\EntitySpecs;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Psr\Container\ContainerInterface;

class EntitySpecsManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $options ??= $container->get(ConfigInterface::class)->getArray($requestedName);

        if (! class_exists($requestedName)) {
            $requestedName = EntitySpecsManager::class;
        }

        return new $requestedName($options);
    }
}
