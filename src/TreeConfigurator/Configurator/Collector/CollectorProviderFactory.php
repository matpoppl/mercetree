<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\Collector;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\EntityManager\Repository\RepositoryManagerInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Repository\TreeDecorationRepositoryInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Repository\TreeRepositoryInterface;
use Mateusz\Mercetree\TreeConfigurator\Feature\EntityFeatureFactory;
use Psr\Container\ContainerInterface;

class CollectorProviderFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $repos = $container->get(RepositoryManagerInterface::class);

        $trees = $repos->get(TreeRepositoryInterface::class);
        $decorations = $repos->get(TreeDecorationRepositoryInterface::class);
        $entityFeatureFactory = new EntityFeatureFactory();

        return new $requestedName($trees, $decorations, $entityFeatureFactory);
    }
}
