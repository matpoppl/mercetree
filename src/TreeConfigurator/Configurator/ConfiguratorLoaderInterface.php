<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator;

interface ConfiguratorLoaderInterface
{
    public function load(string $baseProductId) : ConfiguratorInterface;
}
