<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator;

use Mateusz\Mercetree\TreeConfigurator\Builder\Result\RowExceptionInterface;
use Mateusz\Mercetree\TreeConfigurator\Builder\Validator\TreeValidatorResultInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\BuiltTree\RowInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary\SaleSummaryInterface;

interface ConfiguratorInterface
{
    /**
     * @throws RowExceptionInterface
     */
    public function getRow(string $rowId) : RowInterface;

    public function validate() : TreeValidatorResultInterface;

    public function getSaleSummary() : SaleSummaryInterface;
}
