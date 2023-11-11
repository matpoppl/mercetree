<?php

namespace Mateusz\Mercetree\TreeConfigurator\Feature;

use Mateusz\Mercetree\ProductConfigurator\Feature\FeatureInterface;

class MockFeature implements FeatureInterface
{
    public function __construct(private readonly string $featureSymbol)
    {
    }

    public function getFeatureSymbol(): string
    {
        return $this->featureSymbol;
    }
}
