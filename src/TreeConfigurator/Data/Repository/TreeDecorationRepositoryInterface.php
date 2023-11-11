<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Repository;

use Mateusz\Mercetree\Dbal\Adapter\InvalidTypeException;
use Mateusz\Mercetree\EntityManager\Repository\RepositoryInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset\TreeDecorationsAdapter as Adapter;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\AdapterInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\StatementInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeDecorationEntity;

interface TreeDecorationRepositoryInterface
{
    public function getById(string $id) : ?TreeDecorationEntity;

    /**
     * @return iterable<TreeDecorationEntity>
     */
    public function getAll() : iterable;
}
