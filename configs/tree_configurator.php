<?php

use Laminas\ServiceManager\Factory\InvokableFactory;
use Mateusz\Mercetree\TreeConfigurator\Builder\Constraint\Factory as ConstraintFactory;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result;
use Mateusz\Mercetree\TreeConfigurator\Builder\Validator as BuilderValidator;
use Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary;
use Mateusz\Mercetree\TreeConfigurator\Data\Possibilities;
use Mateusz\Mercetree\TreeConfigurator\Configurator;
use Mateusz\Mercetree\TreeConfigurator\Configurator\Collector;

return [

    Possibilities\PossibilitiesBuilder::class => [
        'config_file' => __DIR__ . '/dataset/possibilities.php',
    ],

    'service_manager' => [
        'aliases' => [
            Result\BuiltTreeProviderInterface::class => Result\BuiltTreeProvider::class,
            ConstraintFactory\ConstraintFromSpecsProviderInterface::class => ConstraintFactory\ConstraintFromSpecsProvider::class,
            BuilderValidator\TreeValidatorInterface::class => BuilderValidator\TreeValidator::class,

            Possibilities\PossibilitiesBuilderInterface::class => Possibilities\PossibilitiesBuilder::class,

            Configurator\ConfiguratorLoaderInterface::class => Configurator\ConfiguratorLoader::class,
            Collector\CollectorProviderInterface::class => Collector\CollectorProvider::class,

            SaleSummary\SaleSummaryProviderInterface::class => SaleSummary\SaleSummaryProvider::class,
        ],
        'factories' => [
            Result\BuiltTreeProvider::class => Result\BuiltTreeProviderFactory::class,
            ConstraintFactory\ConstraintFromSpecsProvider::class => ConstraintFactory\ConstraintFromSpecsProviderFactory::class,
            BuilderValidator\TreeValidator::class => InvokableFactory::class,

            Possibilities\PossibilitiesBuilder::class => Possibilities\PossibilitiesBuilderFactory::class,

            Configurator\ConfiguratorLoader::class => Configurator\ConfiguratorLoaderFactory::class,
            Collector\CollectorProvider::class => Collector\CollectorProviderFactory::class,

            SaleSummary\SaleSummaryProvider::class => SaleSummary\SaleSummaryProviderFactory::class,
        ],
    ],
];
