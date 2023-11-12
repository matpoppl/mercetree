<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator;

use Mateusz\Mercetree\TreeConfigurator\Builder\Result\Provider\BuiltTreeProviderInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Result\Provider\ProviderExceptionInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Validator\TreeValidatorInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\Collector\CollectorProviderInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary\SaleSummaryProviderInterface;

class ConfiguratorLoader implements ConfiguratorLoaderInterface
{
    public function __construct(
        private readonly BuiltTreeProviderInterface $builtTreeProvider,
        private readonly CollectorProviderInterface $collectorProvider,
        private readonly TreeValidatorInterface $treeValidator,
        private readonly SaleSummaryProviderInterface $saleSummaryProvider)
    {
    }

    public function load(string $baseProductId): ConfiguratorInterface
    {
        try {
            $builtTree = $this->builtTreeProvider->get($baseProductId);
        } catch (ProviderExceptionInterface $e) {
            throw ConfiguratorLoaderException::builtTreeError($e);
        }

        try {
            $collector = $this->collectorProvider->get($baseProductId);
        } catch (Collector\ProductException $e) {
            throw ConfiguratorLoaderException::collectorError($e);
        }

        return new Configurator($builtTree, $this->treeValidator, $collector, $this->saleSummaryProvider);
    }
}
