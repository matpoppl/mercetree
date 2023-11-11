<?php

namespace Mateusz\Mercetree\TreeConfigurator\Data\Entity;

abstract class AbstractProduct implements ProductPriceInterface
{
    protected float $price;
    protected int $taxRate;
    protected string $currencyCode;

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

    public function getCurrencyCode(): string
    {
        return $this->currencyCode;
    }

    public function setCurrencyCode(string $currencyCode): void
    {
        $this->currencyCode = $currencyCode;
    }

    public function toStorageRecord() : array
    {
        return [
            'price' => $this->getPrice(),
            'tax_rate' => $this->getTaxRate(),
            'currency_code' => $this->getCurrencyCode(),
        ];
    }

    public function fromStorageRecord(array $record) : void
    {
        $this->setPrice($record['price']);
        $this->setTaxRate($record['tax_rate']);
        $this->setCurrencyCode($record['currency_code']);
    }

    public static function fromExample(array $options) : static
    {
        $ret = new static();
        $ret->fromStorageRecord($options);
        return $ret;
    }
}
