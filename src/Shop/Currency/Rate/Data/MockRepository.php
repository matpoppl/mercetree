<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate\Data;

use Mateusz\Mercetree\Shop\Currency\CurrencyCodeInterface;
use DateTimeInterface;

class MockRepository implements RepositoryInterface
{
    private readonly string $currencyCode;
    private readonly array $rates;

    public function __construct(array $options = null)
    {
        $this->currencyCode = $options['currency_code'] ?? null;
        $this->rates = $options['rates'] ?? [];
    }

    public function get(CurrencyCodeInterface $currencySymbol, DateTimeInterface $date) : ?float
    {
        $currencyCode = $currencySymbol->getCurrencyCode();

        if ($this->currencyCode === $currencyCode) {
            return 1.0;
        }

        $date = $date->format('Y-m-d');

        $key = "{$currencyCode}-{$date}";

        return $this->rates[$key] ?? null;
    }
}
