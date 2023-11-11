<?php

namespace Mateusz\Mercetree\Shop\Tax;

interface TaxCalculatorInterface
{
    public function round(float $amount) : float;

    public function calculate(float $price, int $taxRate) : TaxCalculationResultInterface;

    public function calculateTaxRate(int $taxRate) : float;
}
