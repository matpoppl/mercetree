<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate\Data;

use Psr\SimpleCache\CacheInterface;
use DateTimeInterface;
use Mateusz\Mercetree\Shop\Currency\CurrencyCodeInterface;
use Psr\SimpleCache\InvalidArgumentException;

interface PresenterInterface
{
    public function getRate(CurrencyCodeInterface $currency, DateTimeInterface $date = null) : float;
}
