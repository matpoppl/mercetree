<?php

namespace Mateusz\Mercetree\EntityManager\Repository;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\Dbal\DbalManagerInterface;
use Mateusz\Mercetree\EntityManager\EntitySpecs\EntitySpecsManagerInterface;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Psr\Container\ContainerInterface;

class RepositoryManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $options ??= $container->get(ConfigInterface::class)->getArray($requestedName);

        if (! class_exists($requestedName)) {
            $requestedName = RepositoryManager::class;
        }

        return new $requestedName($container->get(DbalManagerInterface::class), $container->get(EntitySpecsManagerInterface::class), $options);
    }
}
