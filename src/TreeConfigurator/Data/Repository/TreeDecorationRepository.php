<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Repository;

use Mateusz\Mercetree\Dbal\Adapter\InvalidTypeException;
use Mateusz\Mercetree\EntityManager\Repository\RepositoryInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset\TreeDecorationsAdapter as Adapter;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\AdapterInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\StatementInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeDecorationEntity;

class TreeDecorationRepository implements RepositoryInterface, TreeDecorationRepositoryInterface
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

    public function getById(string $id) : ?TreeDecorationEntity
    {
        foreach ($this->getAll() as $entity) {
            if ($id === $entity->getId()) {
                return $entity;
            }
        }

        return null;
    }

    /**
     * @return StatementInterface<TreeDecorationEntity>
     */
    public function getAll() : StatementInterface
    {
        return $this->adapter->query(Adapter::QUERY_GET_ALL);
    }
}
