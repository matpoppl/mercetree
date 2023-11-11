<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate;

use DateTimeInterface;

interface RateProviderInterface
{
    public function getRate(DateTimeInterface $dateTime, string $sourceCurrencyCode, string $targetCurrencyCode) : float;
}
