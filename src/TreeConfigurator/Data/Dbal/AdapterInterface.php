<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Dbal;

use Mateusz\Mercetree\TreeConfigurator\Data\Entity\TreeEntity;

/**
 * @template T
 */
interface AdapterInterface
{
    /**
     * @param string $sql
     * @param array|null $params
     * @return StatementInterface<T>
     */
    public function query(string $sql, array $params = null) : StatementInterface;
}
