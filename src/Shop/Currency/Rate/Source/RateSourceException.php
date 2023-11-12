<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate\Source;

class RateSourceException extends \Exception implements RateSourceExceptionInterface
{
    public static function unsupportedCurrency(RateSourceIdInterface $source, string $currencyCode) : static
    {
        return new static("Unsupported currency `{$currencyCode}` in source `{$source->getId()}`", self::CODE_UNSUPPORTED_CURRENCY);
    }

    public static function dateNotFound(RateSourceIdInterface $source, string $date) : static
    {
        return new static("Date `{$date}` not found in source `{$source->getId()}`", self::CODE_DATE_NOT_FOUND);
    }

    public static function dateCurrencyNotFound(RateSourceIdInterface $source, string $date, string $currencyCode) : static
    {
        return new static("Currency `{$currencyCode}` rate on date `{$date}` not found in source `{$source->getId()}`", self::CODE_DATE_CURRENCY_NOT_FOUND);
    }

    public static function zero(RateSourceIdInterface $source, string $date, string $currencyCode) : static
    {
        return new static("Currency `{$currencyCode}` rate is equal to ZERO on date `{$date}` in source `{$source->getId()}`", self::CODE_ZERO);
    }
}
