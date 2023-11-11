<?php

namespace Mateusz\Mercetree\Shop\Tax;

interface TaxCalculationResultInterface
{
    public function getPriceNet(): float;
    public function getPriceGross(): float;
    public function getTaxValue(): float;
    public function getTaxRate(): int;
}
