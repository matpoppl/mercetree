<?php

namespace Mateusz\Mercetree\TreeConfigurator;

use Mateusz\Mercetree\TreeConfigurator\Builder\Result\Provider\BuiltTreeProviderInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Validator\TreeValidatorInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\ConfiguratorLoaderInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Possibilities\PossibilitiesBuilderInterface;

interface TreeConfiguratorComponentInterface
{
    public function getTreeValidator() : TreeValidatorInterface;
    public function getBuiltTreeProvider() : BuiltTreeProviderInterface;
    public function getConfiguratorLoader() : ConfiguratorLoaderInterface;

    /**
     * @deprecated Demo only, helps with generating records in DB
     */
    public function getPossibilitiesBuilder() : PossibilitiesBuilderInterface;
}
