<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset;

use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\AdapterInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Statement\ArrayDataset\Constraint\ByProduct;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Statement\ArrayDataset\GetAll;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\StatementInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\ConstraintEntity;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeEntity;

/**
 * @implements AdapterInterface<ConstraintEntity>
 */
class ConstraintsAdapter implements AdapterInterface
{
    const QUERY_GET_ALL = 'GET_ALL';
    const QUERY_BY_PRODUCT = 'BY_PRODUCT=';

    /**
     * @var ConstraintEntity[] $records
     */
    private array $records = [];

    public function __construct(array $records)
    {
        foreach ($records as $record) {
            $entity = new ConstraintEntity();
            $entity->fromStorageRecord($record);
            $this->records[] = $entity;
        }
    }

    /**
     * @param string $sql
     * @param array|null $params
     * @return StatementInterface<ConstraintEntity>
     */
    public function query(string $sql, array $params = null): StatementInterface
    {
        return match($sql) {
            self::QUERY_GET_ALL => new GetAll($this->records),
            self::QUERY_BY_PRODUCT => new ByProduct($this->records, $params[self::QUERY_BY_PRODUCT]),
            default => throw new \UnexpectedValueException("Unsupported query `{$sql}`"),
        };
    }
}
