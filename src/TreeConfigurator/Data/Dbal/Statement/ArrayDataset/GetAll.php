<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Statement\ArrayDataset;

/**
 * @template T
 * @extends AbstractStatement<T>
 */
class GetAll extends AbstractStatement
{
    public function __construct(array $records)
    {
        $this->records = $records;
    }
}
