<?php

namespace Mateusz\Mercetree\ProductConfigurator\Constraint;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @template-implements IteratorAggregate<ConstraintInterface>
 */
class ConstraintCollection implements ConstraintCollectionInterface, IteratorAggregate
{
    /**
     * @param ConstraintInterface[] $constraints
     */
    public function __construct(private readonly array $constraints)
    {
        foreach ($constraints as $constraint) {
            if ($constraint instanceof ConstraintInterface) {
                continue;
            }

            $type = is_object($constraint) ? get_class($constraint) : gettype($constraint);
            throw new \UnexpectedValueException("Unsupported constraint type `{$type}`");
        }
    }

    /**
     * @return Traversable<ConstraintInterface>>
     */
    public function getIterator() : Traversable
    {
        return new ArrayIterator($this->constraints);
    }
}
