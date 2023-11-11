<?php

use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset\Factory;
use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\Adapter\ArrayDataset\Constraint;
use Mateusz\Mercetree\TreeConfigurator\Data\Transform;

return [

    ArrayDataset\TreesAdapter::class => [
        'path' => __DIR__ . '/dataset/trees.php',
        'transform' => Transform\ExampleTrees::class,
    ],

    ArrayDataset\TreeDecorationsAdapter::class => [
        'path' => __DIR__ . '/dataset/tree-decorations.php',
        'transform' => Transform\ExampleTreeDecoration::class,
    ],

    ArrayDataset\ConstraintsAdapter::class => [
        'path' => __DIR__ . '/dataset/constraints.php',
    ],

    'service_manager' => [
        'aliases' => [
            Constraint\PhpConfigFileLoaderInterface::class => Constraint\PhpConfigFileLoader::class,
        ],

        'factories' => [
            ArrayDataset\TreesAdapter::class => Factory\FileRecordsAdapterFactory::class,
            ArrayDataset\TreeDecorationsAdapter::class => Factory\FileRecordsAdapterFactory::class,

            Constraint\PhpConfigFileLoader::class => Constraint\PhpConfigFileLoaderFactory::class,
            ArrayDataset\ConstraintsAdapter::class => Factory\ConstraintsFileRecordsAdapterFactory::class,
        ],
    ],
];
