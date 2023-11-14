<?php

namespace Mateusz\Mercetree\Shop;

use Mateusz\Mercetree\ServiceManager\ServiceManagerConstructorAwareInterface;
use Mateusz\Mercetree\ServiceManager\ServiceManagerConstructorAwareTrait;
use Mateusz\Mercetree\Shop\Currency\Converter\CurrencyConverterInterface;
use Mateusz\Mercetree\Shop\Currency\Formatter\CurrencyFormatterInterface;
use Mateusz\Mercetree\Shop\OrderManager\CreateOrderInterface;
use Mateusz\Mercetree\Shop\Tax\TaxCalculatorInterface;
use Mateusz\Mercetree\Shop\View\PreferencesInterface;

class ShopComponent implements ShopComponentInterface, ServiceManagerConstructorAwareInterface
{
    use ServiceManagerConstructorAwareTrait;

    public function getViewPreferences(): PreferencesInterface
    {
        return $this->serviceManager->get(PreferencesInterface::class);
    }

    public function getTaxCalculator(): TaxCalculatorInterface
    {
        return $this->serviceManager->get(TaxCalculatorInterface::class);
    }

    public function getCurrencyConverter(): CurrencyConverterInterface
    {
        return $this->serviceManager->get(CurrencyConverterInterface::class);
    }

    public function getCurrencyFormatter(): CurrencyFormatterInterface
    {
        return $this->serviceManager->get(CurrencyFormatterInterface::class);
    }

    public function getCreateOrder(): CreateOrderInterface
    {
        return $this->serviceManager->get(CreateOrderInterface::class);
    }
}
