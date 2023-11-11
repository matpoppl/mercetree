<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Statement\ArrayDataset;

use ArrayIterator;
use IteratorAggregate;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\StatementInterface;
use Traversable;

/**
 * @template T
 * @implements IteratorAggregate<T>
 * @implements StatementInterface<T>
 */
abstract class AbstractStatement implements StatementInterface, IteratorAggregate
{
    protected array $records;

    public function execute(array $params = null) : bool
    {
        if (null !== $params) {
            throw new \UnexpectedValueException('Immutable statement');
        }

        return true;
    }

    public function count(): int
    {
        return count($this->records);
    }

    /**
     * @return Traversable<T>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->records);
    }
}
