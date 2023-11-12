<?php

namespace Mateusz\Mercetree\ProductConfigurator\Feature;

use ArrayIterator;
use IteratorAggregate;
use Traversable;

/**
 * @implements IteratorAggregate<FeatureInterface>
 */
class FeatureCollection implements FeatureCollectionInterface, IteratorAggregate
{
    /**
     * @var FeatureInterface[]
     */
    private array $features = [];

    public function __construct(array $features = [])
    {
        foreach ($features as $feature) {
            $this->add($feature);
        }
    }

    public function add(FeatureInterface $features) : void
    {
        $this->features[] = $features;
    }

    public function reset() : void
    {
        $this->features = [];
    }

    /**
     * @return Traversable<FeatureInterface>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->features);
    }
}
