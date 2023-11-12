<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary;

use Mateusz\Mercetree\Shop\Currency\Converter\CurrencyConverterInterface;
use Mateusz\Mercetree\Shop\Tax\TaxCalculatorInterface;
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

    /**
     * @param TaxCalculatorInterface $taxCalculator
     * @param CurrencyConverterInterface $currencyConverter
     * @param ViewProductInterface $inputBaseProduct
     * @param ViewProductInterface[] $decorations
     */
    public function __construct(
        private readonly TaxCalculatorInterface $taxCalculator,
        private readonly CurrencyConverterInterface $currencyConverter,
        ViewProductInterface $inputBaseProduct,
        array $decorations
    ) {
        $this->baseProduct = $this->createProductPresentation( $inputBaseProduct );
        $this->decorations = array_map(fn($product) => $this->createProductPresentation($product), $decorations);
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
        return $this->baseProduct;
    }

    /**
     * @return ProductInterface[]
     */
    public function getDecorations() : array
    {
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

        $pricesNet = $this->taxCalculator->round($pricesNet);
        $priceGross = $this->taxCalculator->round($priceGross);
        $taxValue = $this->taxCalculator->round($taxValue);

        return new ProductsSummary($pricesNet, $priceGross, $taxValue);
    }
}
