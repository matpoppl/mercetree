<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Transform;

use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset\RecordsTransformInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeDecorationEntity;

class ExampleTreeDecoration implements RecordsTransformInterface
{
    /**
     * @param array[] $records
     * @return TreeDecorationEntity[]
     */
    public static function create(array $records) : array
    {
        return array_map(fn($row) => TreeDecorationEntity::fromExample($row), $records);
    }

    public function __invoke(array $records): array
    {
        return self::create($records);
    }
}
