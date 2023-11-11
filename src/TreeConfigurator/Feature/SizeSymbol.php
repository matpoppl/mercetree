<?php

namespace Mateusz\Mercetree\TreeConfigurator\Feature;

use Mateusz\Mercetree\ProductConfigurator\Feature\SizeSymbolInterface;

class SizeSymbol implements SizeSymbolInterface
{
    public function __construct(public readonly string $symbol)
    {
    }

    public function getSizeSymbol(): string
    {
        return $this->getFeatureSymbol();
    }

    public function getFeatureSymbol(): string
    {
        return "size:{$this->symbol}";
    }
}
