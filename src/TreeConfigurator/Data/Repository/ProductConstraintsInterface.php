<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Repository;

use Mateusz\Mercetree\TreeConfigurator\Data\Entity\ProductConstraintInterface as Entity;

interface ProductConstraintsInterface
{
    /**
     * @param string $productId
     * @return iterable<Entity>
     */
    public function getByProduct(string $productId) : iterable;
}
