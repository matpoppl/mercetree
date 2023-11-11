<?php

namespace Mateusz\Mercetree\Shop\Tax;

use const PHP_ROUND_HALF_UP;
use const PHP_ROUND_HALF_DOWN;

class TaxCalculator implements TaxCalculatorInterface
{
    private readonly int $roundMode;

    public function __construct(private readonly int $precision, string $mode)
    {
        $this->roundMode = match($mode) {
            'HALF_UP' => PHP_ROUND_HALF_UP,
            'HALF_DOWN' => PHP_ROUND_HALF_DOWN,
            default => throw new \UnexpectedValueException(),
        };
    }

    public function calculate(float $price, int $taxRate) : TaxCalculationResultInterface
    {
        $tax = $this->calculateTaxRate($taxRate);
        $net = $this->round($price);
        $gross = $this->round($net * $tax);

        return new TaxCalculationResult(
            $net,
            $gross,
            $gross - $net,
            $taxRate
        );
    }

    public function round(float $amount) : float
    {
        return round($amount, $this->precision, $this->roundMode);
    }

    public function calculateTaxRate(int $taxRate) : float
    {
        return ($taxRate / 100 + 1);
    }
}
