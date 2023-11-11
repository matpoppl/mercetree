<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Result;

interface BuiltTreeProviderInterface
{
    public function get(string $treeId) : BuiltTreeInterface;
}
