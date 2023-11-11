<?php

namespace Mateusz\Mercetree\Shop\Currency\Formatter;

interface CurrencyFormatterInterface
{
    public function format(float $amount, ?string $currencyCode = null) : string|false;
}
