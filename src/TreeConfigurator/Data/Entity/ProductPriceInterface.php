<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Entity;

interface ProductPriceInterface
{
    public function getPrice() : float;

    public function getTaxRate() : int;

    public function getCurrencyCode() : string;
}
