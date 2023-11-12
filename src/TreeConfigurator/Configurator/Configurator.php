<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator;

use Mateusz\Mercetree\TreeConfigurator\Builder\Result\BuiltTreeInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Validator\TreeValidatorInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Validator\TreeValidatorResultInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\BuiltTree\RowInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\BuiltTree\Rows;
use Mateusz\Mercetree\TreeConfigurator\Configurator\BuiltTree\RowsInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\Collector\FeatureCollectorInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary\SaleSummaryInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary\SaleSummaryProviderInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\Structure\Structure;
use Mateusz\Mercetree\TreeConfigurator\Configurator\Structure\StructureInterface;

class Configurator implements ConfiguratorInterface
{
    private RowsInterface $rows;

    public function __construct(
        private readonly BuiltTreeInterface $buildTree,
        private readonly TreeValidatorInterface $treeValidator,
        private readonly FeatureCollectorInterface $collector,
        private readonly SaleSummaryProviderInterface $saleSummaryProvider)
    {
        $this->rows = new Rows($buildTree->getRows(), $collector);
    }

    public function getRow(string $rowId) : RowInterface
    {
        return $this->rows->get($rowId);
    }

    public function validate() : TreeValidatorResultInterface
    {
        return $this->treeValidator->validate($this->buildTree);
    }

    public function getSaleSummary() : SaleSummaryInterface
    {
        return $this->saleSummaryProvider->create( $this->collector );
    }

    public function getStructure() : StructureInterface
    {
        return new Structure( $this->buildTree );
    }
}
