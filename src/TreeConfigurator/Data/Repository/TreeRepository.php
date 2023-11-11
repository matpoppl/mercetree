<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Repository;

use Mateusz\Mercetree\Dbal\Adapter\InvalidTypeException;
use Mateusz\Mercetree\EntityManager\Repository\RepositoryInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset\TreesAdapter as Adapter;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\AdapterInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\StatementInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeEntity;

class TreeRepository implements RepositoryInterface, TreeRepositoryInterface
{
    /**
     * @throws InvalidTypeException
     */
    public function __construct(private readonly AdapterInterface $adapter)
    {
        if (! $adapter instanceof Adapter) {
            throw new InvalidTypeException($adapter, Adapter::class);
        }
    }

    /**
     * @param string $id
     * @return ?TreeEntity
     */
    public function getById(string $id) : ?TreeEntity
    {
        foreach ($this->getAll() as $tree) {
            if ($id === $tree->getId()) {
                return $tree;
            }

        }
        return null;
    }

    /**
     * @return StatementInterface<TreeEntity>
     */
    public function getAll() : StatementInterface
    {
        return $this->adapter->query(Adapter::QUERY_GET_ALL);
    }

    /**
     * @param string $size
     * @return StatementInterface<TreeEntity>
     */
    public function getBySize(string $size) : StatementInterface
    {
        return $this->adapter->query(Adapter::QUERY_BY_SIZE, [Adapter::QUERY_BY_SIZE => $size]);
    }
}
