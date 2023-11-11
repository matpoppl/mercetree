<?php

namespace Mateusz\Mercetree\TreeConfigurator\Feature;

class ModelType implements ModelTypeInterface
{
    public function __construct(public readonly string $code)
    {
    }

    public function getModelTypeSymbol(): string
    {
        return $this->getFeatureSymbol();
    }

    public function getFeatureSymbol(): string
    {
        return "model:{$this->code}";
    }
}
