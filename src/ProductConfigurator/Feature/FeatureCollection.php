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

    /**
     * @param iterable<FeatureInterface> $collection
     * @param class-string $type
     * @return FeatureCollectionInterface
     */
    public static function filterCollectionByType(iterable $collection, string $type) : FeatureCollectionInterface
    {
        if ($collection instanceof Traversable) {
            $collection = iterator_to_array($collection);
        }

        if (! is_array($collection)) {
            throw new \UnexpectedValueException('Unsupported collection type');
        }

        $features = array_filter($collection, fn($feature) => is_a($feature, $type));
        return new self($features);
    }

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

    /**
     * @return Traversable<FeatureInterface>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator($this->features);
    }
}
