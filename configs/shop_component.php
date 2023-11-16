<?php

use Mateusz\Mercetree\Shop\OrderManager\Warehouse;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Handler as WarehouseHandler;
use Mateusz\Mercetree\Shop\Tax;
use Mateusz\Mercetree\Shop\View;
use Mateusz\Mercetree\Shop\Currency;
use Mateusz\Mercetree\Shop\Currency\Rate;
use Mateusz\Mercetree\Shop\Currency\Converter;
use Mateusz\Mercetree\Shop\Currency\Formatter;
use Mateusz\Mercetree\Shop\OrderManager;
use Mateusz\Mercetree\Shop\OrderManager\Handler as OrderManagerHandler;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository as WarehouseRepository;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder;

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
            $dateToday => ['EUR' => 4.44]
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

            OrderManager\CreateOrderInterface::class => OrderManager\CreateOrder::class,

            Warehouse\WarehouseManagerInterface::class => Warehouse\WarehouseManager::class,
            WarehouseRepository\WarehouseReadRepositoryInterface::class => WarehouseRepository\WarehouseReadRepository::class,
            WarehouseRepository\WarehouseWriteRepositoryInterface::class => WarehouseRepository\WarehouseWriteRepository::class,
            WarehouseRepository\WarehouseRepositoryManagerInterface::class => WarehouseRepository\WarehouseRepositoryManager::class,
            CreateOrder\CreateOrderManagerInterface::class => CreateOrder\CreateOrderManager::class,
        ],
        'factories' => [
            View\Preferences::class => View\PreferencesFactory::class,

            Tax\TaxCalculator::class => Tax\TaxCalculatorFactory::class,

            Currency\CurrencyCode::class => Currency\DefaultCurrencyCodeFactory::class,
            Converter\Converter::class => Converter\ConverterFactory::class,
            Rate\RateProvider::class => Rate\RateProviderFactory::class,
            Formatter\Formatter::class => Formatter\FormatterFactory::class,

            Warehouse\WarehouseManager::class => Warehouse\WarehouseManagerFactory::class,
            OrderManager\CreateOrder::class => OrderManager\CreateOrderFactory::class,
            WarehouseRepository\WarehouseReadRepository::class => WarehouseRepository\WarehouseReadRepositoryFactory::class,
            WarehouseRepository\WarehouseWriteRepository::class => WarehouseRepository\WarehouseWriteRepositoryFactory::class,
            WarehouseRepository\WarehouseRepositoryManager::class => WarehouseRepository\WarehouseRepositoryManagerFactory::class,
            CreateOrder\CreateOrderManager::class => InvokableFactory::class,

            Warehouse\StockItemsRegistry::class => InvokableFactory::class,
            WarehouseHandler\RepositoryBeginHandler::class => WarehouseHandler\RepositoryBeginHandlerFactory::class,
            WarehouseHandler\RepositoryCloseHandler::class => WarehouseHandler\RepositoryCloseHandlerFactory::class,

            OrderManagerHandler\WarehouseBeginHandler::class => OrderManagerHandler\WarehouseHandlerFactory::class,
            OrderManagerHandler\WarehouseCloseHandler::class => OrderManagerHandler\WarehouseHandlerFactory::class,
            OrderManagerHandler\CreateOrderSubmitHandler::class => OrderManagerHandler\CreateOrderHandlerFactory::class,
            OrderManagerHandler\CreateOrderCloseHandler::class => OrderManagerHandler\CreateOrderHandlerFactory::class,
        ],
    ],
];
