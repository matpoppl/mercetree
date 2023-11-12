<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary;

use Mateusz\Mercetree\Shop\Currency\Converter\CurrencyConverterInterface;
use Mateusz\Mercetree\Shop\Tax\TaxCalculatorInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\Collector\ProductCollectorInterface;

class SaleSummaryProvider implements SaleSummaryProviderInterface
{
    public function __construct(private readonly TaxCalculatorInterface $taxCalculator, private readonly CurrencyConverterInterface $currencyConverter)
    {
    }

    public function create(ProductCollectorInterface $collector) : SaleSummaryInterface
    {
        $baseProduct = $collector->getBaseProduct();
        $decorations = $collector->getDecorations();
        return new SaleSummary($this->taxCalculator, $this->currencyConverter, $baseProduct, $decorations);
    }
}
