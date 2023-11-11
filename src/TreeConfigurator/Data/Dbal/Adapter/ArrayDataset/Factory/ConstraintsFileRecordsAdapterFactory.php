<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset\Constraint\PhpConfigFileLoader;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Mateusz\Mercetree\ServiceManager\Factory\ClassResolver;
use Mateusz\Mercetree\ServiceManager\Factory\ClassResolverInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset\RecordsTransformInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\AdapterInterface;
use Psr\Container\ContainerInterface;

class ConstraintsFileRecordsAdapterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $options ??= $container->get(ConfigInterface::class)->getArray($requestedName);

        $requestedName = $container->get(ClassResolver::class)->resolve($requestedName, AdapterInterface::class);

        $transformType = $options['transform'] ?? null;

        $transform = $transformType
            ? $container->get(ClassResolverInterface::class)->create($transformType, RecordsTransformInterface::class)
            : null;

        $records = $container->get(PhpConfigFileLoader::class)->load( $options['path'] ?? null );

        return new $requestedName( $transform ? $transform($records) : $records );
    }
}
