<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Possibilities;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\EntityManager\Repository\RepositoryManagerInterface;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Mateusz\Mercetree\ServiceManager\Config\ServiceConfigResolverInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Repository\TreeRepositoryInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Repository\TreeDecorationRepositoryInterface;
use Psr\Container\ContainerInterface;

class PossibilitiesBuilderFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $repos = $container->get(RepositoryManagerInterface::class);

        $trees = $repos->get(TreeRepositoryInterface::class);
        $decorations = $repos->get(TreeDecorationRepositoryInterface::class);

        $config = $container->get(ConfigInterface::class);

        $options ??= $container->get(ServiceConfigResolverInterface::class)->get($requestedName, $config);

        return new $requestedName($trees, $decorations, $options);
    }
}
