<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Entity;

abstract class AbstractProduct implements ProductPriceInterface
{
    protected float $price;
    protected int $taxRate;
    protected string $currencySymbol;

    public function getPrice(): float
    {
        return $this->price;
    }

    public function setPrice(float $price): void
    {
        $this->price = $price;
    }

    public function getTaxRate(): int
    {
        return $this->taxRate;
    }

    public function setTaxRate(int $taxRate): void
    {
        $this->taxRate = $taxRate;
    }

    public function getCurrencySymbol(): string
    {
        return $this->currencySymbol;
    }

    public function setCurrencySymbol(string $currencySymbol): void
    {
        $this->currencySymbol = $currencySymbol;
    }

    public function toStorageRecord() : array
    {
        return [
            'price' => $this->getPrice(),
            'tax_rate' => $this->getTaxRate(),
            'currency_symbol' => $this->getCurrencySymbol(),
        ];
    }

    public function fromStorageRecord(array $record) : void
    {
        $this->setPrice($record['price']);
        $this->setTaxRate($record['tax_rate']);
        $this->setCurrencySymbol($record['currency_symbol']);
    }

    public static function fromExample(array $options) : static
    {
        $ret = new static();
        $ret->fromStorageRecord($options);
        return $ret;
    }
}
