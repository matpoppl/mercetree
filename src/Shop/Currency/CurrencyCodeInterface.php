<?php

namespace Mateusz\Mercetree\Shop\Currency;

interface CurrencyCodeInterface
{
    /**
     * ISO 4217 Code, ex. USD, EUR, PLN
     * @return string
     */
    public function getCurrencyCode() : string;

}
