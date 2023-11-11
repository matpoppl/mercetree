<?php

namespace Mateusz\Mercetree\Intl;

use NumberFormatter as BaseFormatter;

class NumberFormatter implements NumberFormatterInterface
{
    private readonly BaseFormatter $innerFormatter;

    public function __construct(private readonly string $defaultCurrency, string $locale)
    {
        $this->innerFormatter = new BaseFormatter( $locale, BaseFormatter::CURRENCY );
    }

    public function formatCurrency(float $number, ?string $currencySymbol = null) : string|false
    {
        $currencySymbol ??= $this->defaultCurrency;
        return $this->innerFormatter->formatCurrency($number, $currencySymbol);
    }
}
