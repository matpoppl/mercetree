<?php

use Laminas\ServiceManager\Factory\InvokableFactory;
use Mateusz\Mercetree\Event;
use Mateusz\Mercetree\Shop\Tax;
use Mateusz\Mercetree\Shop\View;
use Mateusz\Mercetree\Shop\Currency;
use Mateusz\Mercetree\Shop\Currency\Rate;
use Mateusz\Mercetree\Shop\Currency\Converter;
use Mateusz\Mercetree\Shop\Currency\Formatter;
use Mateusz\Mercetree\Shop\OrderManager;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository as WarehouseRepository;
use Mateusz\Mercetree\Shop\OrderManager\Event as OrderManagerEvent;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Listener as CreateOrderListener;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Listener as WarehouseListener;

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

    OrderManager\CreateOrder::class => [
        'listeners' => [
            [OrderManagerEvent\CreateOrderEventInterface::class, WarehouseListener\ReadRepository\CreateOrderListener::class],
            [OrderManagerEvent\CreateOrderProcessEventInterface::class, WarehouseListener\ReadRepository\CreateOrderProcessListener::class],
            [OrderManagerEvent\CreateOrderEventInterface::class, WarehouseListener\WriteRepository\CreateOrderListener::class],
            [OrderManagerEvent\CreateOrderEventInterface::class, CreateOrderListener\CreateOrderListener::class],
            [OrderManagerEvent\CreateOrderProcessEventInterface::class, CreateOrderListener\CreateOrderProcessListener::class],
        ],
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

            Warehouse\StockItemsRegistryInterface::class => Warehouse\StockItemsRegistry::class,
            WarehouseRepository\WarehouseReadRepositoryInterface::class => WarehouseRepository\WarehouseReadRepository::class,
            WarehouseRepository\WarehouseWriteRepositoryInterface::class => WarehouseRepository\WarehouseWriteRepository::class,
            CreateOrder\CreateOrderManagerInterface::class => CreateOrder\CreateOrderManager::class,

            Psr\EventDispatcher\EventDispatcherInterface::class => Event\EventDispatcher::class,
            Event\ListenerProviderInterface::class => Event\ListenerProvider::class,

            OrderManagerEvent\CreateOrderEventManagerInterface::class => OrderManagerEvent\CreateOrderEventManager::class,
        ],
        'factories' => [
            View\Preferences::class => View\PreferencesFactory::class,

            Tax\TaxCalculator::class => Tax\TaxCalculatorFactory::class,

            Currency\CurrencyCode::class => Currency\DefaultCurrencyCodeFactory::class,
            Converter\Converter::class => Converter\ConverterFactory::class,
            Rate\RateProvider::class => Rate\RateProviderFactory::class,
            Formatter\Formatter::class => Formatter\FormatterFactory::class,

            OrderManager\CreateOrder::class => OrderManager\CreateOrderFactory::class,
            WarehouseRepository\WarehouseReadRepository::class => WarehouseRepository\WarehouseReadRepositoryFactory::class,
            WarehouseRepository\WarehouseWriteRepository::class => WarehouseRepository\WarehouseWriteRepositoryFactory::class,
            CreateOrder\CreateOrderManager::class => InvokableFactory::class,

            Warehouse\StockItemsRegistry::class => InvokableFactory::class,

            OrderManagerEvent\CreateOrderEventManager::class => OrderManagerEvent\CreateOrderEventManagerFactory::class,
            Event\EventDispatcher::class => Event\EventDispatcherFactory::class,
            Event\ListenerProvider::class => Event\ListenerProviderFactory::class,

            WarehouseListener\ReadRepository\CreateOrderListener::class => WarehouseListener\ReadRepository\CreateOrderListenerFactory::class,
            WarehouseListener\ReadRepository\CreateOrderProcessListener::class => WarehouseListener\ReadRepository\CreateOrderProcessListenerFactory::class,
            WarehouseListener\WriteRepository\CreateOrderListener::class => WarehouseListener\WriteRepository\CreateOrderListenerFactory::class,

            CreateOrderListener\CreateOrderListener::class => CreateOrder\Listener\CreateOrderListenerFactory::class,
            CreateOrderListener\CreateOrderProcessListener::class => CreateOrder\Listener\CreateOrderListenerFactory::class,
        ],
    ],
];
