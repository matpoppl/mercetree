<?php

namespace Mateusz\Mercetree\TreeConfigurator\Feature;

use Mateusz\Mercetree\ProductConfigurator\Feature\CoatingInterface;

class HandPainted implements CoatingInterface
{
    public function __construct(public readonly string $code)
    {
    }

    public function getCoatingSymbol(): string
    {
        return $this->getFeatureSymbol();
    }

    public function getFeatureSymbol(): string
    {
        return "coating(hand_painted:{$this->code})";
    }
}
