<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary;

use Mateusz\Mercetree\Shop\Currency\Converter\CurrencyConverterInterface;
use Mateusz\Mercetree\Shop\Tax\TaxCalculatorInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\Collector\ProductCollectorInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary\Presentation\ProductInterface;
use Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary\Presentation\Product;
use Mateusz\Mercetree\Shop\Product\View\ProductInterface as ViewProductInterface;

class SaleSummary implements SaleSummaryInterface
{
    private ProductInterface $baseProduct;

    /**
     * @var ProductInterface[]
     */
    private array $decorations;

    public function __construct(private readonly ProductCollectorInterface $collector, private readonly TaxCalculatorInterface $taxCalculator, private readonly CurrencyConverterInterface $currencyConverter)
    {
    }

    public function createProductPresentation(ViewProductInterface $product) : ProductInterface
    {
        $converted = $this->currencyConverter->convert($product->getBasePriceNet(), $product->getCurrencyCode());
        $price = $this->taxCalculator->calculate($converted->getAmount(), $product->getTaxRate());

        return new Product(
            $product->getName(),
            $price->getPriceNet(),
            $price->getPriceGross(),
            $price->getTaxRate(),
            $price->getTaxValue(),
            $converted->getCurrencyCode());
    }

    public function getBaseProduct() : ProductInterface
    {
        $this->baseProduct ??= $this->createProductPresentation( $this->collector->getBaseProduct() );
        return $this->baseProduct;
    }

    /**
     * @return ProductInterface[]
     */
    public function getDecorations() : array
    {
        $this->decorations ??= array_map(fn($product) => $this->createProductPresentation($product), $this->collector->getDecorations());
        return $this->decorations;
    }

    public function getProductsSummary() : ProductsSummaryInterface
    {
        $pricesNet = 0;
        $priceGross = 0;
        $taxValue = 0;

        foreach ([$this->getBaseProduct(), ...$this->getDecorations()] as $product) {
            $pricesNet += $product->getPriceNet();
            $priceGross += $product->getPriceGross();
            $taxValue += $product->getTaxValue();
        }

        return new ProductsSummary($pricesNet, $priceGross, $taxValue);
    }
}
