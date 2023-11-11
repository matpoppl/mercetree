<?php

use Mateusz\Mercetree\Application\Component\ComponentFactory;
use Mateusz\Mercetree\Shop;
use Mateusz\Mercetree\TreeConfigurator;

return [

    'service_manager' => [
        'aliases' => [
            Shop\ShopComponentInterface::class => Shop\ShopComponent::class,
            TreeConfigurator\TreeConfiguratorComponentInterface::class => TreeConfigurator\TreeConfiguratorComponent::class,
        ],
        'factories' => [
            Shop\ShopComponent::class => ComponentFactory::class,
            TreeConfigurator\TreeConfiguratorComponent::class => ComponentFactory::class,
        ],
    ],

    Shop\ShopComponent::class => [
        'config_file' => __DIR__ . '/shop_component.php',
    ],

    TreeConfigurator\TreeConfiguratorComponent::class => [
        'config_file' => __DIR__ . '/tree_configurator.php',
    ],
];
