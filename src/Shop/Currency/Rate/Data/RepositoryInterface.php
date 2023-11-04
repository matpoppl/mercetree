<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate\Data;

use Mateusz\Mercetree\Shop\Currency\CurrencyCodeInterface;
use DateTimeInterface;

interface RepositoryInterface
{
    public function get(CurrencyCodeInterface $currencySymbol, DateTimeInterface $date) : ?float;
}
