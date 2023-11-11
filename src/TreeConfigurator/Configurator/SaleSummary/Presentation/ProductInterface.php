<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary\Presentation;

interface ProductInterface
{
    public function getName(): string;
    public function getPriceNet(): float;
    public function getPriceGross(): float;
    public function getCurrencyCode(): string;
    public function getTaxValue(): float;
    public function getTaxRate(): int;
}
