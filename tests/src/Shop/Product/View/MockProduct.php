<?php

namespace Mateusz\Mercetree\Shop\Product\View;

class MockProduct implements ProductInterface
{
    public function __construct(
        private readonly string $name,
        private readonly float $basePriceNet,
        private readonly int $taxRate,
        private readonly string $currencyCode
    ) { }

    public function getName(): string
    {
        return $this->name;
    }

    public function getBasePriceNet(): float
    {
        return $this->basePriceNet;
    }

    public function getTaxRate(): int
    {
        return $this->taxRate;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }
}
