<?php

namespace Mateusz\Mercetree\Shop\Currency\Converter;

use Mateusz\Mercetree\Shop\Currency\CurrencyCodeInterface;

class Result implements AmountResultInterface
{
    public function __construct(private readonly float $amount, private readonly CurrencyCodeInterface $currencyCode)
    {
    }

    public function getAmount() : float
    {
        return $this->amount;
    }

    public function getCurrencyCode(): string
    {
        return $this->currencyCode->getCurrencyCode();
    }
}
