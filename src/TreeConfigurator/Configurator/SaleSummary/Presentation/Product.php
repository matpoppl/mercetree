<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary\Presentation;

class Product implements ProductInterface
{
    public function __construct(
        private readonly string $name,
        private readonly float $priceNet,
        private readonly float $priceGross,
        private readonly float $taxRate,
        private readonly float $taxValue,
        private readonly string $currencyCode)
    {}

    public function getName(): string
    {
        return $this->name;
    }

    public function getPriceNet(): float
    {
        return $this->priceNet;
    }

    public function getPriceGross(): float
    {
        return $this->priceGross;
    }

    public function getCurrencySymbol(): string
    {
        return $this->currencyCode;
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
