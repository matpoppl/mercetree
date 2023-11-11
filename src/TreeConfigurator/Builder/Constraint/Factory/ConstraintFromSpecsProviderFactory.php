<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Constraint\Factory;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;

class ConstraintFromSpecsProviderFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new $requestedName($container, $options);
    }
}
