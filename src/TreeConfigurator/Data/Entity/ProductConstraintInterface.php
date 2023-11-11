<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Entity;

use Mateusz\Mercetree\TreeConfigurator\Builder\Constraint\Factory\ConstraintSpecsInterface;

interface ProductConstraintInterface extends ConstraintSpecsInterface
{
    public function getSlotName() : ?string;
}
