<?php

namespace Mateusz\Mercetree\Shop\Currency\Converter;

use DateTime;
use DateTimeInterface;
use Mateusz\Mercetree\Shop\Currency\CurrencyCodeInterface;
use Mateusz\Mercetree\Shop\Currency\Rate\RateProviderInterface;

class Converter implements CurrencyConverterInterface
{
    private readonly DateTimeInterface $today;
    public function __construct(private readonly RateProviderInterface $rateProvider, private readonly CurrencyCodeInterface $targetCurrency)
    {
        $this->today = new DateTime('today');
    }

    public function convert(float $amount, string $sourceCurrencyCode): AmountResultInterface
    {
        $rate = $this->rateProvider->getRate($this->today, $sourceCurrencyCode, $this->targetCurrency->getCurrencyCode());
        return new Result($amount * $rate, $this->targetCurrency);
    }
}
