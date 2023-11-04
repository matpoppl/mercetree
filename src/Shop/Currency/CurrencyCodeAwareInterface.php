<?php

namespace Mateusz\Mercetree\Shop\Currency;

interface CurrencyCodeAwareInterface
{
    public function getCurrencyCode() : CurrencyCodeInterface;
    
    public function setCurrencyCode(CurrencyCodeInterface $currencyCode) : void;
}
