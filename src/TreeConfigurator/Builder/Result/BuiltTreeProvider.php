<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Result;

use Mateusz\Mercetree\TreeConfigurator\Builder\Constraint\Factory\ConstraintFromSpecsProviderInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\TreeBuilder;
use Mateusz\Mercetree\TreeConfigurator\Data\Repository\ProductConstraintsInterface;

class BuiltTreeProvider implements BuiltTreeProviderInterface
{
    public function __construct(private readonly ConstraintFromSpecsProviderInterface $constraintProvider, private readonly ProductConstraintsInterface $productConstraints)
    {
    }

    public function get(string $treeId): BuiltTreeInterface
    {
        $builder = new TreeBuilder();

        foreach ($this->productConstraints->getByProduct($treeId) as $entity) {

            $constraint = ($this->constraintProvider)($entity);
            $slotName = $entity->getSlotName();

            if (null === $slotName) {
                $builder->addConstraint($constraint);
            } else {
                $builder->getRow($slotName)->addConstraint($constraint);
            }
        }

        return $builder->buildTree();
    }
}
