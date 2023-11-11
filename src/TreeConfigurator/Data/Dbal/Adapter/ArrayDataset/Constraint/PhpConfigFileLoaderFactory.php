<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset\Constraint;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class PhpConfigFileLoaderFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new $requestedName($container);
    }
}
