<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Result;

use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureCollectionInterface;
use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureInterface;

interface RowInterface
{
    public function getRowId() : string;

    public function add(FeatureInterface $feature) : static;

    public function getFeatures() : FeatureCollectionInterface;

    public function reset() : static;
}
