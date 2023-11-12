<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\Provider\BuiltTreeProviderInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Validator\TreeValidatorInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\Collector\CollectorProviderInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary\SaleSummaryProviderInterface;
use Psr\Container\ContainerInterface;

class ConfiguratorLoaderFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $builtTreeProvider = $container->get(BuiltTreeProviderInterface::class);
        $collectorProvider = $container->get(CollectorProviderInterface::class);
        $treeValidator = $container->get(TreeValidatorInterface::class);
        $saleSummaryProvider = $container->get(SaleSummaryProviderInterface::class);
        return new $requestedName($builtTreeProvider, $collectorProvider, $treeValidator, $saleSummaryProvider);
    }
}
