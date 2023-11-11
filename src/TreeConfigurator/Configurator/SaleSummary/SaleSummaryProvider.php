<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary;

use Mateusz\Mercetree\Shop\Tax\TaxCalculatorInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\Collector\ProductCollectorInterface;

class SaleSummaryProvider implements SaleSummaryProviderInterface
{
    public function __construct(private readonly TaxCalculatorInterface $taxCalculator)
    {
    }

    public function create(ProductCollectorInterface $collector) : SaleSummaryInterface
    {
        return new SaleSummary($collector, $this->taxCalculator);
    }
}
