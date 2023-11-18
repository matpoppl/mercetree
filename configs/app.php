<?php

use Laminas\ServiceManager\Factory\InvokableFactory;
use Mateusz\Mercetree\Application\Component;
use Mateusz\Mercetree\Application\Config\Loader\File as ConfigFileLoader;
use Mateusz\Mercetree\SimpleCache\NullCache;
use Mateusz\Mercetree\Dbal;
use Mateusz\Mercetree\EntityManager;
use Mateusz\Mercetree\EntityManager\Repository as EMRepository;
use Mateusz\Mercetree\TreeConfigurator\Data\Entity;
use Mateusz\Mercetree\TreeConfigurator\Data\Repository as EntityRepository;
use Mateusz\Mercetree\EntityManager\EntitySpecs;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset;
use Mateusz\Mercetree\ServiceManager\Factory as SMFactory;
use Mateusz\Mercetree\ServiceManager\Config as SMConfig;
use Mateusz\Mercetree\TreeConfigurator\Data\Repository\ProductConstraintsInterface;
use Mateusz\Mercetree\View\Renderer as ViewRenderer;
use Mateusz\Mercetree\Intl\Translator;
use \Mateusz\Mercetree\Application\Logger\MockLogger;

return [

    Component\ComponentManager::class => [
        'config_file' => __DIR__ . '/components.php',
    ],

    EntitySpecs\EntitySpecsManager::class => [
        'aliases' => [
            EntityRepository\TreeRepositoryInterface::class => EntityRepository\TreeRepository::class,
            EntityRepository\TreeRepository::class => Entity\TreeEntity::class,

            EntityRepository\TreeDecorationRepositoryInterface::class => EntityRepository\TreeDecorationRepository::class,
            EntityRepository\TreeDecorationRepository::class => Entity\TreeDecorationEntity::class,

            ProductConstraintsInterface::class => Entity\ConstraintEntity::class,
            EntityRepository\ConstraintRepository::class => Entity\ConstraintEntity::class,
        ],

        'entities' => [
            Entity\TreeEntity::class => [
                'repository_type' => EntityRepository\TreeRepository::class,
            ],
            Entity\TreeDecorationEntity::class => [
                'repository_type' => EntityRepository\TreeDecorationRepository::class,
            ],
            Entity\ConstraintEntity::class => [
                'repository_type' => EntityRepository\ConstraintRepository::class,
            ],
        ],
    ],

    EMRepository\RepositoryManager::class => [
        EntityRepository\TreeRepository::class => [
            'adapter' => ArrayDataset\TreesAdapter::class,
        ],
        EntityRepository\TreeDecorationRepository::class => [
            'adapter' => ArrayDataset\TreeDecorationsAdapter::class,
        ],
        EntityRepository\ConstraintRepository::class => [
            'adapter' => ArrayDataset\ConstraintsAdapter::class,
        ],
    ],

    EntityManager\EntityManager::class => [

    ],

    Dbal\DbalManager::class => [
        'config_file' => __DIR__ . '/dbal.php',
    ],

    ViewRenderer\PhtmlRenderer::class => [
        'paths' => [__DIR__ . '/../views/'],
    ],

    'service_manager' => [

        'aliases' => [
            SMConfig\ServiceConfigResolverInterface::class => SMConfig\ServiceConfigResolver::class,
            SMFactory\ClassResolverInterface::class => SMFactory\ClassResolver::class,
            ConfigFileLoader\PhpConfigFileLoaderInterface::class => ConfigFileLoader\PhpConfigFileLoader::class,

            Component\ComponentManagerInterface::class => Component\ComponentManager::class,

            'cache.fast' => NullCache::class,

            \Psr\Log\LoggerInterface::class => MockLogger::class,

            Dbal\DbalManagerInterface::class => Dbal\DbalManager::class,
            EntityManager\EntityManagerInterface::class => EntityManager\EntityManager::class,
            EMRepository\RepositoryManagerInterface::class => EMRepository\RepositoryManager::class,
            EntitySpecs\EntitySpecsManagerInterface::class => EntitySpecs\EntitySpecsManager::class,

            Translator\TranslatorInterface::class => Translator\Translator::class,
            ViewRenderer\ViewRendererInterface::class => ViewRenderer\PhtmlRenderer::class,
        ],

        'factories' => [
            ConfigFileLoader\PhpConfigFileLoader::class => InvokableFactory::class,
            SMFactory\ClassResolver::class => InvokableFactory::class,
            SMConfig\ServiceConfigResolver::class => SMConfig\ServiceConfigResolverFactory::class,

            Component\ComponentManager::class => Component\ComponentManagerFactory::class,

            NullCache::class => InvokableFactory::class,

            MockLogger::class => InvokableFactory::class,

            Dbal\DbalManager::class => Dbal\DbalManagerFactory::class,
            EntityManager\EntityManager::class => EntityManager\EntityManagerFactory::class,
            EMRepository\RepositoryManager::class => EMRepository\RepositoryManagerFactory::class,
            EntitySpecs\EntitySpecsManager::class => EntitySpecs\EntitySpecsManagerFactory::class,

            Translator\Translator::class => InvokableFactory::class,
            ViewRenderer\PhtmlRenderer::class => ViewRenderer\PhtmlRendererFactory::class,
        ],
    ],
];
