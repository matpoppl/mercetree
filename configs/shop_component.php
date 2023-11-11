<?php

use Mateusz\Mercetree\Intl;
use Mateusz\Mercetree\Shop\Tax;
use Mateusz\Mercetree\Shop\View;
use Mateusz\Mercetree\Shop\Currency;
use Mateusz\Mercetree\Shop\Currency\Rate\Data;

return [

    Intl\NumberFormatter::class => [
        'locale' => 'pl_PL',
        'default_currency' => 'PLN',
    ],

    Tax\TaxCalculator::class => [
        'precision' => 2,
        'round_mode' => 'HALF_UP',
    ],

    Currency\CurrencyCode::class => [
        'currency_code' => 'PLN',
        'symbol' => 'zł',
    ],

    'service_manager' => [
        'aliases' => [
            Currency\CurrencyCodeInterface::class => Currency\CurrencyCode::class,
            View\PreferencesInterface::class => View\Preferences::class,
            Data\PresenterInterface::class => Data\Presenter::class,

            Data\RepositoryInterface::class => Data\MockRepository::class,

            Tax\TaxCalculatorInterface::class => Tax\TaxCalculator::class,
            Intl\NumberFormatterInterface::class => Intl\NumberFormatter::class,
        ],
        'factories' => [
            Currency\CurrencyCode::class => Currency\DefaultCurrencyCodeFactory::class,
            View\Preferences::class => View\PreferencesFactory::class,
            Data\Presenter::class => Data\PresenterFactory::class,

            Data\MockRepository::class => Data\MockRepositoryFactory::class,

            Tax\TaxCalculator::class => Tax\TaxCalculatorFactory::class,
            Intl\NumberFormatter::class => Intl\NumberFormatterFactory::class,
        ],
    ],
];
