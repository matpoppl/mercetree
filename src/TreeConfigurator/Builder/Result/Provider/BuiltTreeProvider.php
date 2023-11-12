<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Result\Provider;

use Mateusz\Mercetree\TreeConfigurator\Builder\Constraint\Factory\ConstraintFromSpecsProviderInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\BuiltTreeInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\TreeBuilder;
use Mateusz\Mercetree\TreeConfigurator\Data\Repository\ProductConstraintsInterface;

class BuiltTreeProvider implements BuiltTreeProviderInterface
{
    public function __construct(private readonly ConstraintFromSpecsProviderInterface $constraintProvider, private readonly ProductConstraintsInterface $productConstraints)
    {
    }

    public function get(string $treeId): BuiltTreeInterface
    {
        $foundProduct = false;
        $builder = new TreeBuilder();

        foreach ($this->productConstraints->getByProduct($treeId) as $entity) {

            $foundProduct = true;
            $constraint = ($this->constraintProvider)($entity);
            $slotName = $entity->getSlotName();

            if (! $constraint) {
                continue;
            }

            if (null === $slotName) {
                $builder->addConstraint($constraint);
            } else {
                $builder->getRow($slotName)->addConstraint($constraint);
            }
        }

        if (! $foundProduct) {
            throw ProviderException::notFound($treeId);
        }

        return $builder->buildTree();
    }
}
