<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate;

use DateTimeInterface;
use Mateusz\Mercetree\Shop\Currency\Rate\Source\RateSourceExceptionInterface;
use Mateusz\Mercetree\Shop\Currency\Rate\Source\RateSourceInterface;

class RateProvider implements RateProviderInterface
{
    /**
     * @param string $sourceCurrencyCode
     * @param RateSourceInterface $rates
     */
    public function __construct(private readonly string $sourceCurrencyCode, private readonly RateSourceInterface $rates)
    {
    }

    public function getRate(DateTimeInterface $dateTime, string $sourceCurrencyCode, string $targetCurrencyCode) : float
    {
        // PLN | PLN PLN 1
        // PLN | PLN EUR 4.44
        // PLN | EUR PLN 0.22
        // PLN | USD PLN 0.24

        if ($sourceCurrencyCode === $this->sourceCurrencyCode) {
            return ($targetCurrencyCode === $this->sourceCurrencyCode) ? 1.0 : $this->getSourceRate($dateTime, $targetCurrencyCode);
        }

        if ($targetCurrencyCode === $this->sourceCurrencyCode) {
            return 1.0 / $this->getSourceRate($dateTime, $sourceCurrencyCode);
        }

        $foreignA = $this->getSourceRate($dateTime, $sourceCurrencyCode);
        $foreignB = $this->getSourceRate($dateTime, $targetCurrencyCode);

        return $foreignA / $foreignB;
    }

    /**
     * @throws RateSourceExceptionInterface
     */
    private function getSourceRate(DateTimeInterface $dateTime, string $targetCurrencyCode) : float
    {
        return $this->rates->getRate($dateTime, $this->sourceCurrencyCode, $targetCurrencyCode);
    }
}
