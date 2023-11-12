<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Result\Provider;

use Mateusz\Mercetree\TreeConfigurator\Builder\Result\BuiltTreeInterface;

interface BuiltTreeProviderInterface
{
    /**
     * @throws ProviderExceptionInterface
     */
    public function get(string $treeId) : BuiltTreeInterface;
}
