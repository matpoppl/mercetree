<?php

namespace Mateusz\Mercetree\EntityManager;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\EntityManager\Repository\RepositoryManagerInterface;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Psr\Container\ContainerInterface;

class EntityManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new $requestedName($container->get(RepositoryManagerInterface::class));
    }
}
