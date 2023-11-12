<?php

namespace Mateusz\Mercetree\TreeConfigurator\Builder\Result;

use Mateusz\Mercetree\ProductConfigurator\Constraint\ConstraintCollectionInterface;
use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureCollection;
use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureCollectionInterface;
use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureInterface;

class Row implements RowInterface
{
    private readonly FeatureCollection $features;

    public function __construct(private readonly string $rowId, private readonly ConstraintCollectionInterface $constraints)
    {
        $this->features = new FeatureCollection();
    }

    public function getConstraints() : ConstraintCollectionInterface
    {
        return $this->constraints;
    }

    public function getRowId() : string
    {
        return $this->rowId;
    }

    public function reset() : static
    {
        $this->features->reset();
        return $this;
    }

    public function add(FeatureInterface $feature) : static
    {
        $this->features->add($feature);
        return $this;
    }

    /**
     * @return FeatureCollectionInterface<FeatureInterface>
     */
    public function getFeatures() : FeatureCollectionInterface
    {
        return $this->features;
    }
}
