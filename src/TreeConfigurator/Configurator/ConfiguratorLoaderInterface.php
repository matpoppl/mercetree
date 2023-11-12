<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator;

interface ConfiguratorLoaderInterface
{
    /**
     * @throws ConfiguratorLoaderExceptionInterface
     */
    public function load(string $baseProductId) : ConfiguratorInterface;
}
