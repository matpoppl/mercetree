<?php

namespace Mateusz\Mercetree\Shop\Currency;

class CurrencyCode implements CurrencyCodeInterface
{
    public function __construct(private readonly string $currencyCode)
    {}

    public function getCurrencyCode() : string
    {
        return $this->currencyCode;
    }
}
