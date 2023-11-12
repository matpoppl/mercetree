<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary;

interface ProductsSummaryInterface
{
    public function getPriceNet(): float;

    public function getPriceGross(): float;

    public function getTaxValue(): float;
}
