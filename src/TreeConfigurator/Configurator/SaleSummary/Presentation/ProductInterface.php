<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary\Presentation;

interface ProductInterface
{
    public function getName(): string;
    public function getQuantity(): int;
    public function getPriceNet(): float;
    public function getPriceGross(): float;
    public function getCurrencySymbol(): string;
    public function getTaxValue(): float;
    public function getTaxRate(): int;
}
