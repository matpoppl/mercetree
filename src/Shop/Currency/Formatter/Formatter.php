<?php

namespace Mateusz\Mercetree\Shop\Currency\Formatter;

use Mateusz\Mercetree\Shop\Currency\CurrencyCodeInterface;
use NumberFormatter;

class Formatter implements CurrencyFormatterInterface
{
    private readonly NumberFormatter $innerFormatter;

    public function __construct(private readonly CurrencyCodeInterface $outputCurrencyCode, string $locale)
    {
        $this->innerFormatter = new NumberFormatter( $locale, NumberFormatter::CURRENCY );
    }

    public function format(float $amount, ?string $currencyCode = null): string|false
    {
        $currencyCode ??= $this->outputCurrencyCode->getCurrencyCode();
        return $this->innerFormatter->formatCurrency($amount, $currencyCode);
    }
}
