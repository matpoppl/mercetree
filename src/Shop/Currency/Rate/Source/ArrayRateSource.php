<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate\Source;

use DateTimeInterface;

final class ArrayRateSource implements RateSourceInterface, RateSourceIdInterface
{
    /**
     * @param array<string,array<string, float>> $rates { date: { code: amount } }
     */
    public function __construct(private readonly string $sourceCurrencyCode, private readonly array $rates)
    {
    }

    public function getId(): string
    {
        return self::class;
    }

    public function getRate(DateTimeInterface $dateTime, string $sourceCurrencyCode, string $targetCurrencyCode): float
    {
        if ($sourceCurrencyCode === $this->sourceCurrencyCode) {
            return ($targetCurrencyCode === $this->sourceCurrencyCode) ? 1.0 : $this->getSourceRate($dateTime, $targetCurrencyCode);
        }

        if ($targetCurrencyCode !== $this->sourceCurrencyCode) {
            throw RateSourceException::unsupportedCurrency($this, $targetCurrencyCode);
        }

        return 1.0 / $this->getSourceRate($dateTime, $sourceCurrencyCode);
    }

    /**
     * @throws RateSourceException
     */
    private function getSourceRate(DateTimeInterface $dateTime, string $targetCurrencyCode) : float
    {
        $dateKey = $dateTime->format('Y-m-d');

        if (! array_key_exists($dateKey, $this->rates)) {
            throw RateSourceException::dateNotFound($this, $dateKey);
        }

        if (! array_key_exists($targetCurrencyCode, $this->rates[$dateKey])) {
            throw RateSourceException::dateCurrencyNotFound($this, $dateKey, $targetCurrencyCode);
        }

        $rate = $this->rates[$dateKey][$targetCurrencyCode];

        if (0.0 === $rate) {
            throw RateSourceException::zero($this, $dateKey, $targetCurrencyCode);
        }

        return $rate;
    }
}
