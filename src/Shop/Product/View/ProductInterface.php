<?php

namespace Mateusz\Mercetree\Shop\Product\View;

interface ProductInterface extends ProductPriceInterface
{
    public function getName() : string;
}
