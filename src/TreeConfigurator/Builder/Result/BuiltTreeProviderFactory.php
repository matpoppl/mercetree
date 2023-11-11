<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Result;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\EntityManager\Repository\RepositoryManagerInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Constraint\Factory\ConstraintFromSpecsProviderInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Repository\ProductConstraintsInterface;
use Psr\Container\ContainerInterface;

class BuiltTreeProviderFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $provider = $container->get(ConstraintFromSpecsProviderInterface::class);
        $repo = $container->get(RepositoryManagerInterface::class)->get(ProductConstraintsInterface::class);
        return new $requestedName($provider, $repo);
    }
}
