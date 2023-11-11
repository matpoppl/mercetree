<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Result;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintCollectionInterface;
use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureCollection;
use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureCollectionInterface;
use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureInterface;

interface RowInterface
{
    public function add(FeatureInterface $feature) : static;
}
