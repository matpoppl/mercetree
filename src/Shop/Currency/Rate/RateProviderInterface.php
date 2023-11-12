<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate;

use DateTimeInterface;
use Mateusz\Mercetree\Shop\Currency\Rate\Source\RateSourceExceptionInterface;

interface RateProviderInterface
{
    /**
     * @throws RateSourceExceptionInterface
     */
    public function getRate(DateTimeInterface $dateTime, string $sourceCurrencyCode, string $targetCurrencyCode) : float;
}
