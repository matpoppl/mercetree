<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate;

use DateTimeInterface;

class RateProvider implements RateProviderInterface
{
    /**
     * @param string $sourceCurrencyCode
     * @param array<string, float> $rates
     */
    public function __construct(private readonly string $sourceCurrencyCode, private readonly array $rates)
    {
    }

    public function getRate(DateTimeInterface $dateTime, string $sourceCurrencyCode, string $targetCurrencyCode) : float
    {
        if ($targetCurrencyCode === $this->sourceCurrencyCode) {
            return 1.0;
        }

        $date = $dateTime->format('Y-m-d');

        $key = "{$targetCurrencyCode}-{$date}";

        return $this->rates[$key];
    }
}
