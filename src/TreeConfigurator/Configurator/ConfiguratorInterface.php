<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator;

use Mateusz\Mercetree\TreeConfigurator\Builder\Result\RowExceptionInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Validator\TreeValidatorResultInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\BuiltTree\RowInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary\SaleSummaryInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\Structure\StructureInterface;

interface ConfiguratorInterface
{
    /**
     * @throws RowExceptionInterface
     */
    public function getRow(string $rowId) : RowInterface;

    public function validate() : TreeValidatorResultInterface;

    public function getSaleSummary() : SaleSummaryInterface;

    public function getStructure() : StructureInterface;
}
