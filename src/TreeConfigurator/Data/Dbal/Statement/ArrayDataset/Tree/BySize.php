<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Statement\ArrayDataset\Tree;

use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Statement\ArrayDataset\AbstractStatement;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeEntity;

/**
 * @extends AbstractStatement<TreeEntity>
 */
class BySize extends AbstractStatement
{
    /**
     * @param TreeEntity[] $records
     * @param string $size
     */
    public function __construct(array $records, string $size)
    {
        $this->records = array_filter($records, fn($record) => $record->getSize() === $size);
    }
}
