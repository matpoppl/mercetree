<?php

use Mateusz\Mercetree\Shop\View\Preferences;
use Mateusz\Mercetree\Shop\View\PreferencesInterface;
use Mateusz\Mercetree\Shop\View\PreferencesFactory;
use Mateusz\Mercetree\Shop\Currency\CurrencyCodeInterface;
use Mateusz\Mercetree\Shop\Currency\CurrencyCode;
use Mateusz\Mercetree\Shop\Currency\DefaultCurrencyCodeFactory;

return [

    CurrencyCode::class => [
        'currency_code' => 'PLN',
        'symbol' => 'zł',
    ],
    
    'service_manager' => [
        'aliases' => [
            CurrencyCodeInterface::class => CurrencyCode::class,
            PreferencesInterface::class => Preferences::class,
        ],
        'factories' => [
            Preferences::class => PreferencesFactory::class,
            CurrencyCode::class => DefaultCurrencyCodeFactory::class,
        ],
    ],
];