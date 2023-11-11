<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset;

interface RecordsTransformInterface
{
    public function __invoke(array $records) : array;
}
