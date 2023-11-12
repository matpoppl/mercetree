<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator;

interface ConfiguratorLoaderExceptionInterface extends \Throwable
{
    const CODE_BUILT_TREE_ERROR = 1;
    const CODE_COLLECTOR_ERROR = 2;
}
