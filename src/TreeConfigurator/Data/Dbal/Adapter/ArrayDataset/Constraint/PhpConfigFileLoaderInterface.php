<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset\Constraint;

interface PhpConfigFileLoaderInterface
{
    public function load(string $pathname) : array;
}
