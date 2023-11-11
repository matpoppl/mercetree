<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Repository;

use Mateusz\Mercetree\Dbal\Adapter\InvalidTypeException;
use Mateusz\Mercetree\EntityManager\Repository\RepositoryInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset\TreesAdapter as Adapter;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\AdapterInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\StatementInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeEntity;

interface TreeRepositoryInterface
{
    /**
     * @return ?TreeEntity
     */
    public function getById(string $id) : ?TreeEntity;

    /**
     * @return iterable<TreeEntity>
     */
    public function getAll() : iterable;
}
