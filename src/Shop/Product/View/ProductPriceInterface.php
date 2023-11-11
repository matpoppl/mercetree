<?php

namespace Mateusz\Mercetree\Shop\Product\View;

interface ProductPriceInterface
{
    public function getBasePriceNet() : float;

    public function getTaxRate() : int;

    public function getCurrencySymbol() : string;

    public function getQuantity() : int;
}
