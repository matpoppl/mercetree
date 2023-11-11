<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Statement\ArrayDataset\Constraint;

use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Statement\ArrayDataset\AbstractStatement;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\ConstraintEntity;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeEntity;

/**
 * @extends AbstractStatement<ConstraintEntity>
 */
class ByProduct extends AbstractStatement
{
    /**
     * @param ConstraintEntity[] $records
     * @param string $productId
     */
    public function __construct(array $records, string $productId)
    {
        $this->records = array_filter($records, fn($record) => $record->getProductId() === $productId);
    }
}
