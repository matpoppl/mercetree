<?php

namespace Mateusz\Mercetree\TreeConfigurator\Feature;

use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeDecorationEntity;

class EntityFeatureFactory implements EntityFeatureFactoryInterface
{

    public function create(TreeDecorationEntity $entity): FeatureInterface
    {
        $coating = $entity->getCoating();

        if (!str_contains($coating, ':')) {
            throw new \UnexpectedValueException("Unsupported coating type format `{$coating}`");
        }

        [$coatingName, $coatingValue] = explode(':', $coating, 2);

        if (! in_array($coatingName , ['color', ''])) {
            throw new \UnexpectedValueException("Unsupported coating type `{$coating}`");
        }

        return Bauble::createFromArray([
            'model' => $entity->getModel(),
            'size' => $entity->getSize(),
            $coatingName => $coatingValue,
        ]);
    }
}
