<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary;

use Mateusz\Mercetree\Shop\Product\View\MockProduct;
use Mateusz\Mercetree\Shop\ShopComponentInterface;
use Mateusz\Mercetree\TestApplication;
use PHPUnit\Framework\TestCase;
use Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary\Presentation\ProductInterface;

class SaleSummaryTest extends TestCase
{
    public function testSummary()
    {
        $component = TestApplication::getInstance()->getComponent(ShopComponentInterface::class);

        $baseProduct = new MockProduct('foo', 4, 11, 'PLN');

        $decorations = [
            new MockProduct('foo', 3, 11, 'PLN'),
            new MockProduct('foo', 2, 11, 'PLN'),
            new MockProduct('foo', 1, 11, 'PLN')
        ];

        $summary = new SaleSummary($component->getTaxCalculator(), $component->getCurrencyConverter(), $baseProduct, $decorations);

        $this->productTest($baseProduct, $summary->getBaseProduct());

        $i = 0;
        foreach ($summary->getDecorations() as $decoration) {
            $this->productTest($decorations[$i++], $decoration);
        }

        $totals = $summary->getProductsSummary();

        self::assertEquals(10, $totals->getPriceNet());
        self::assertEquals(11.1, $totals->getPriceGross());
        self::assertEquals(1.1, $totals->getTaxValue());
    }

    private function productTest(MockProduct $input, ProductInterface $output)
    {
        $gross = $input->getBasePriceNet() * ($input->getTaxRate() / 100 + 1);

        self::assertEquals($input->getName(), $output->getName());
        self::assertEquals($input->getBasePriceNet(), $output->getPriceNet());
        self::assertEquals($gross, $output->getPriceGross());
        self::assertEquals('PLN', $output->getCurrencyCode());
        self::assertEquals($gross - $input->getBasePriceNet(), $output->getTaxValue());
        self::assertEquals($input->getTaxRate(), $output->getTaxRate());
    }
}
