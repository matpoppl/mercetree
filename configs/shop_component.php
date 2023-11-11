<?php

use Mateusz\Mercetree\Shop\Tax;
use Mateusz\Mercetree\Shop\View;
use Mateusz\Mercetree\Shop\Currency;
use Mateusz\Mercetree\Shop\Currency\Rate;
use Mateusz\Mercetree\Shop\Currency\Converter;
use Mateusz\Mercetree\Shop\Currency\Formatter;

$dateToday = date('Y-m-d');

return [

    // output currency code
    Currency\CurrencyCode::class => [
        'currency_code' => 'PLN', // PLN|EUR
    ],

    // output currency formatter
    Formatter\Formatter::class => [
        'locale' => 'pl_PL',
    ],

    // mock rates provider
    Rate\RateProvider::class => [
        'source_currency_code' => 'PLN',
        'rates' => [
            "EUR-{$dateToday}" => 4.44,
        ],
    ],

    Tax\TaxCalculator::class => [
        'precision' => 2,
        'round_mode' => 'HALF_UP',
    ],

    'service_manager' => [
        'aliases' => [
            View\PreferencesInterface::class => View\Preferences::class,

            Tax\TaxCalculatorInterface::class => Tax\TaxCalculator::class,

            Currency\CurrencyCodeInterface::class => Currency\CurrencyCode::class,
            Converter\CurrencyConverterInterface::class => Converter\Converter::class,
            Rate\RateProviderInterface::class => Rate\RateProvider::class,
            Formatter\CurrencyFormatterInterface::class => Formatter\Formatter::class,
        ],
        'factories' => [
            View\Preferences::class => View\PreferencesFactory::class,

            Tax\TaxCalculator::class => Tax\TaxCalculatorFactory::class,

            Currency\CurrencyCode::class => Currency\DefaultCurrencyCodeFactory::class,
            Converter\Converter::class => Converter\ConverterFactory::class,
            Rate\RateProvider::class => Rate\RateProviderFactory::class,
            Formatter\Formatter::class => Formatter\FormatterFactory::class,
        ],
    ],
];
