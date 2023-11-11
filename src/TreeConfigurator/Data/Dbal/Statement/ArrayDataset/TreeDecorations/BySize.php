<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Statement\ArrayDataset\TreeDecorations;

use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Statement\ArrayDataset\AbstractStatement;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeDecorationEntity;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeEntity;

/**
 * @extends AbstractStatement<TreeDecorationEntity>
 */
class BySize extends AbstractStatement
{
    /**
     * @param TreeDecorationEntity[] $records
     * @param string $size
     */
    public function __construct(array $records, string $size)
    {
        $this->records = array_filter($records, fn($record) => $record->getSize() === $size);
    }
}
