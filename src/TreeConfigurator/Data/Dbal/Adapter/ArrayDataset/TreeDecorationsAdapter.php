<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset;

use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\AdapterInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Statement\ArrayDataset\GetAll;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Statement\ArrayDataset\TreeDecorations as Statement;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\StatementInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeDecorationEntity;

/**
 * @implements AdapterInterface<TreeDecorationEntity>
 */
class TreeDecorationsAdapter implements AdapterInterface
{
    const QUERY_GET_ALL = 'GET_ALL';
    const QUERY_BY_SIZE = 'BY_SIZE=';

    /**
     * @param TreeDecorationEntity[] $records
     */
    public function __construct(private readonly array $records)
    {}

    public function query(string $sql, array $params = null): StatementInterface
    {
        return match($sql) {
            self::QUERY_GET_ALL => new GetAll($this->records),
            self::QUERY_BY_SIZE => new Statement\BySize($this->records, $params[self::QUERY_BY_SIZE]),
        };
    }
}
