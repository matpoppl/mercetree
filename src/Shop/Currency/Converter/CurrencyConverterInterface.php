<?php

namespace Mateusz\Mercetree\Shop\Currency\Converter;

interface CurrencyConverterInterface
{
    public function convert(float $amount, string $sourceCurrencyCode) : AmountResultInterface;
}
