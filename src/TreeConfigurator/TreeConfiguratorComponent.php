<?php

namespace Mateusz\Mercetree\TreeConfigurator;

use Mateusz\Mercetree\ServiceManager\ServiceManagerConstructorAwareInterface;
use Mateusz\Mercetree\ServiceManager\ServiceManagerConstructorAwareTrait;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\Provider\BuiltTreeProviderInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Validator\TreeValidatorInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\ConfiguratorLoaderInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\PossibilitiesBuilderInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class TreeConfiguratorComponent implements TreeConfiguratorComponentInterface, ServiceManagerConstructorAwareInterface
{
    use ServiceManagerConstructorAwareTrait;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getBuiltTreeProvider() : BuiltTreeProviderInterface
    {
        return $this->serviceManager->get(BuiltTreeProviderInterface::class);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getTreeValidator(): TreeValidatorInterface
    {
        return $this->serviceManager->get(TreeValidatorInterface::class);
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getConfiguratorLoader(): ConfiguratorLoaderInterface
    {
        return $this->serviceManager->get(ConfiguratorLoaderInterface::class);
    }

    /**
     * @deprecated Demo only, helps with generating records in DB
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getPossibilitiesBuilder(): PossibilitiesBuilderInterface
    {
        return $this->serviceManager->get(PossibilitiesBuilderInterface::class);
    }
}
