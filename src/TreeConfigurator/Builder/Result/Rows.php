<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Result;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<RowInterface>
 */
class Rows implements RowsInterface, IteratorAggregate
{
    /**
     * @param Row[] $rows
     */
    public function __construct(private readonly array $rows)
    {
    }

    public function has(string $rowId) : bool
    {
        return array_key_exists($rowId, $this->rows);
    }

    public function get(string $rowId) : RowInterface
    {
        if (! array_key_exists($rowId, $this->rows)) {
            throw RowException::dontExists($rowId);
        }

        return $this->rows[$rowId];
    }

    /**
     * @return Traversable<RowInterface>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->rows);
    }
}
