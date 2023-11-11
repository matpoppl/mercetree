<?php

namespace Mateusz\Mercetree\TreeConfigurator\Feature;

use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeDecorationEntity;

interface EntityFeatureFactoryInterface
{
    public function create(TreeDecorationEntity $entity) : FeatureInterface;
}
