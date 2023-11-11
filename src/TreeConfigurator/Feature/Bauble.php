<?php

namespace Mateusz\Mercetree\TreeConfigurator\Feature;

use ArrayIterator;
use IteratorAggregate;
use Mateusz\Mercetree\ProductConfigurator\Feature\CoatingInterface;
use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureCollectionInterface;
use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureInterface;
use Mateusz\Mercetree\ProductConfigurator\Feature\SizeSymbolInterface;
use Traversable;

/**
 * @implements IteratorAggregate<FeatureInterface>
 */
class Bauble implements FeatureInterface, FeatureCollectionInterface, TreeDecorationInterface, IteratorAggregate
{
    public static function createFromArray(array $options) : static
    {
        $size = $options['size'] ?? null;
        $color = $options['color'] ?? null;
        $handPainted = $options['handPainted'] ?? null;
        $model = $options['model'] ?? null;

        return static::create($size, $color, $handPainted, $model);
    }

    public static function create(string $size, ?string $color = null, ?string $handPainted = null, ?string $model = null) : static
    {
        $coating = match(true) {
            (null !== $color) => new Color( $color ),
            (null !== $handPainted) => new HandPainted( $handPainted ),
            // ... add more coatings
        };

        if (! $size) {
            throw new \UnexpectedValueException('Size required');
        }

        if (! $coating) {
            throw new \UnexpectedValueException('Coating required, use one of [color, handPainted]');
        }

        $model = new ModelType( $model ?: 'bauble' );

        return new static(
            $model,
            new SizeSymbol($size),
            $coating
        );
    }

    public function __construct(public readonly ModelTypeInterface $modelType, public readonly SizeSymbolInterface $sizeSymbol, public readonly CoatingInterface $color)
    {
    }

    public function getFeatureSymbol(): string
    {
        return "{$this->modelType->getModelTypeSymbol()}/{$this->sizeSymbol->getSizeSymbol()}/{$this->color->getCoatingSymbol()}";
    }

    /**
     * @return Traversable<SizeSymbolInterface>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator([$this->modelType, $this->sizeSymbol, $this->color]);
    }
}
