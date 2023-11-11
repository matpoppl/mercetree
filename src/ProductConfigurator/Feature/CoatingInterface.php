<?php

namespace Mateusz\Mercetree\ProductConfigurator\Feature;

interface CoatingInterface extends FeatureInterface
{
    public function getCoatingSymbol() : string;
}
