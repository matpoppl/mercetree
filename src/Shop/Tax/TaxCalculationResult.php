<?php

namespace Mateusz\Mercetree\Shop\Tax;

class TaxCalculationResult implements TaxCalculationResultInterface
{
    public function __construct(
        private readonly float $priceNet,
        private readonly float $priceGross,
        private readonly float $taxValue,
        private readonly int $taxRate)
    {}

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

    public function getTaxRate(): int
    {
        return $this->taxRate;
    }
}
