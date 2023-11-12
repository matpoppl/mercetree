<?php

namespace Mateusz\Mercetree\TreeConfigurator\Feature;

use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeDecorationEntity;

class EntityFeatureFactory implements EntityFeatureFactoryInterface
{
    public function create(TreeDecorationEntity $entity): FeatureInterface
    {
        return Bauble::create(size: $entity->getSize(), coating: $entity->getCoating(), model: $entity->getModel());
    }
}
