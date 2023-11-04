<?php

use Mateusz\Mercetree\SimpleCache\NullCache;
use Mateusz\Mercetree\Shop\Currency\Rate\View\MockRepositoryFactory;
use Mateusz\Mercetree\Shop\Currency\Rate\View\RepositoryInterface;
use Mateusz\Mercetree\Shop\Currency\Rate\View\MockRepository;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Mateusz\Mercetree\Shop\ShopComponent;
use Mateusz\Mercetree\Application\Component\ComponentManager;
use Mateusz\Mercetree\Application\Component\ComponentManagerFactory;
use Mateusz\Mercetree\Application\Component\ComponentManagerInterface;
use Mateusz\Mercetree\Application\Component\ComponentFactory;

$todayDate = date('Y-m-d');

return [
    
    ComponentManager::class => [
        'components' => [
            ShopComponent::class => ComponentFactory::class,
        ],
        
        ShopComponent::class => [
            'config_file' => __DIR__ . '/shop_component.php',
        ],
    ],
    
    MockRepositoryFactory::class => [
        'rates' => [
            "EUR-{$todayDate}" => 4.431,
            "USD-{$todayDate}" => 4.863,
        ],
    ],
    
    'service_manager' => [
        
        'aliases' => [
            'cache.fast' => NullCache::class,
            RepositoryInterface::class => MockRepository::class,
            ComponentManagerInterface::class => ComponentManager::class,
        ],
        
        'factories' => [
            NullCache::class => InvokableFactory::class,
            MockRepository::class => MockRepositoryFactory::class,
            ComponentManager::class => ComponentManagerFactory::class,
        ],
    ],
];