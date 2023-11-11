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

    public function get(string $rowId) : RowInterface
    {
        if (! array_key_exists($rowId, $this->rows)) {
            throw new \DomainException("Row `{$rowId}` don't exists");
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
