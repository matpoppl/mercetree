<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate\Source;

use DateTimeInterface;

interface RateSourceInterface
{
    public function getId() : string;

    /**
     * @throws RateSourceExceptionInterface
     */
    public function getRate(DateTimeInterface $dateTime, string $sourceCurrencyCode, string $targetCurrencyCode) : float;
}
