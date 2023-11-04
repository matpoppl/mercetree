<?php

namespace Mateusz\Mercetree\Shop\View;

use Mateusz\Mercetree\Shop\Currency\CurrencyCodeInterface;

interface PreferencesInterface
{
    public function getCurrencyCode() : CurrencyCodeInterface;
}
