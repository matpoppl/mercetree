<?php

namespace Mateusz\Mercetree\Shop\View;

use Mateusz\Mercetree\Shop\Currency\CurrencyCodeInterface;
use Mateusz\Mercetree\Shop\Currency\CurrencyCodeAwareInterface;

class Preferences implements PreferencesInterface, CurrencyCodeAwareInterface
{
    private CurrencyCodeInterface $currencyCode;
    
    public function setCurrencyCode(CurrencyCodeInterface $currencyCode) : void
    {
        $this->currencyCode = $currencyCode;
    }
    
    public function getCurrencyCode() : CurrencyCodeInterface
    {
        return $this->currencyCode;
    }
}
