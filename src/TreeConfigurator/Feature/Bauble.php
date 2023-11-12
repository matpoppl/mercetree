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
        $coating = $options['coating'] ?? null;

        $size = $options['size'] ?? null;
        $model = $options['model'] ?? null;

        foreach ([
            'color' => 'color',
             'handPainted' => 'hand-paint'
        ] as $optionKey => $coatingPrefix) {
            $coatingValue = $options[$optionKey] ?? null;
            if ($coatingValue) {
                $coating = "{$coatingPrefix}:{$coatingValue}";
            }
        }

        return static::create($size, $coating, $model);
    }

    public static function create(string $size, string $coating, ?string $model = null) : static
    {
        $model = new ModelType( $model ?: 'bauble' );
        $coating = new Coating($coating);

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
     * @return Traversable<FeatureInterface>
     */
    public function getIterator(): Traversable
    {
        return new ArrayIterator([$this->modelType, $this->sizeSymbol, $this->color]);
    }
}
