<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Repository;

use Mateusz\Mercetree\Dbal\Adapter\InvalidTypeException;
use Mateusz\Mercetree\EntityManager\Repository\RepositoryInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset\ConstraintsAdapter as Adapter;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\AdapterInterface;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity\ConstraintEntity;

class ConstraintRepository implements RepositoryInterface, ProductConstraintsInterface
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
     * @param string $productId
     * @return iterable<ConstraintEntity>
     */
    public function getByProduct(string $productId): iterable
    {
        return $this->adapter->query(Adapter::QUERY_BY_PRODUCT, [Adapter::QUERY_BY_PRODUCT => $productId]);
    }
}
