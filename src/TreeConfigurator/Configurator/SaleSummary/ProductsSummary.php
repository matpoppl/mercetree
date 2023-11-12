<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary;

class ProductsSummary implements ProductsSummaryInterface
{
    public function __construct(private readonly float $priceNet, private readonly float $priceGross, private readonly float $taxValue)
    {
    }

    public function getPriceNet(): float
    {
        return $this->priceNet;
    }

    public function getPriceGross(): float
    {
        return $this->priceGross;
    }

    public function getTaxValue(): float
    {
        return $this->taxValue;
    }
}
