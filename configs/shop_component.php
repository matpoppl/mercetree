<?php

use Laminas\ServiceManager\Factory\InvokableFactory;
use Mateusz\Mercetree\Event;
use Mateusz\Mercetree\Shop\Currency;
use Mateusz\Mercetree\Shop\Currency\Converter;
use Mateusz\Mercetree\Shop\Currency\Formatter;
use Mateusz\Mercetree\Shop\Currency\Rate;
use Mateusz\Mercetree\Shop\OrderManager;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Event as CreateOrderEvent;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrder\Listener as CreateOrderListener;
use Mateusz\Mercetree\Shop\OrderManager\Event as OrderManagerEvent;
use Mateusz\Mercetree\Shop\OrderManager\Listener as OrderManagerListener;
use Mateusz\Mercetree\Shop\OrderManager\Order\Request as OrderManagerRequest;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Event as WarehouseEvent;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Listener as WarehouseListener;
use Mateusz\Mercetree\Shop\OrderManager\Warehouse\Repository as WarehouseRepository;
use Mateusz\Mercetree\Shop\Tax;
use Mateusz\Mercetree\Shop\View;

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
            [OrderManagerEvent\OrderRequestCreatedEvent::class, WarehouseListener\ReadRepository\OrderRequestCreatedListener::class],
            [OrderManagerEvent\OrderRequestCancelledEvent::class, WarehouseListener\ReadRepository\OrderRequestCancelledListener::class],
            [OrderManagerEvent\OrderRequestAcceptedEvent::class, WarehouseListener\ReadRepository\OrderRequestAcceptedListener::class],
            [WarehouseEvent\OrderStockDecreasedEvent::class, WarehouseListener\WriteRepository\OrderStockDecreasedListener::class],
            [WarehouseEvent\OrderStockRestoreEvent::class, WarehouseListener\WriteRepository\OrderStockRestoreListener::class],

            [OrderManagerEvent\OrderRequestCreatedEvent::class, CreateOrderListener\OrderRequestCreatedListener::class],
            [OrderManagerEvent\OrderRequestCancelledEvent::class, CreateOrderListener\OrderRequestCancelledListener::class],
            [OrderManagerEvent\OrderRequestAcceptedEvent::class, CreateOrderListener\OrderRequestAcceptedListener::class],

            [WarehouseEvent\OrderStockDecreasedEvent::class, OrderManagerListener\OrderStockDecreasedListener::class],
            [CreateOrderEvent\CreatedOrderEvent::class, OrderManagerListener\CreatedOrderListener::class],
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

            Warehouse\OrderStockManagerInterface::class => Warehouse\OrderStockManager::class,

            OrderManagerRequest\RequestStatusManagerInterface::class => OrderManagerRequest\RequestStatusManager::class,
            Warehouse\OrderStockServiceInterface::class => Warehouse\OrderStockService::class,

            CreateOrder\CreateOrderServiceInterface::class => CreateOrder\CreateOrderService::class,
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

            Warehouse\OrderStockManager::class => Warehouse\OrderStockManagerFactory::class,
            WarehouseListener\ReadRepository\OrderRequestCreatedListener::class => WarehouseListener\ReadRepository\OrderStockListenerFactory::class,
            WarehouseListener\ReadRepository\OrderRequestCancelledListener::class => WarehouseListener\ReadRepository\OrderStockListenerFactory::class,
            WarehouseListener\ReadRepository\OrderRequestAcceptedListener::class => WarehouseListener\ReadRepository\OrderStockListenerFactory::class,

            Warehouse\OrderStockService::class => Warehouse\OrderStockDecreaseServiceFactory::class,
            OrderManagerRequest\RequestStatusManager::class => InvokableFactory::class,
            OrderManagerListener\OrderStockDecreasedListener::class => OrderManagerRequest\RequestStatusManagerListenerFactory::class,
            OrderManagerListener\CreatedOrderListener::class => OrderManagerRequest\RequestStatusManagerListenerFactory::class,
            CreateOrderListener\OrderRequestCreatedListener::class => CreateOrderListener\OrderRequestCreatedListenerFactory::class,
            CreateOrderListener\OrderRequestCancelledListener::class => CreateOrderListener\OrderRequestCreatedListenerFactory::class,
            CreateOrderListener\OrderRequestAcceptedListener::class => CreateOrderListener\OrderRequestCreatedListenerFactory::class,

            CreateOrder\CreateOrderService::class => CreateOrder\CreateOrderServiceFactory::class,

            WarehouseListener\WriteRepository\OrderStockDecreasedListener::class => WarehouseListener\WriteRepository\OrderStockListenerFactory::class,
            WarehouseListener\WriteRepository\OrderStockRestoreListener::class => WarehouseListener\WriteRepository\OrderStockListenerFactory::class,
        ],
    ],
];
