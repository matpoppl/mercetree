<?php

namespace Mateusz\Mercetree\Shop;

use Mateusz\Mercetree\Intl\NumberFormatterInterface;
use Mateusz\Mercetree\ServiceManager\ServiceManagerConstructorAwareInterface;
use Mateusz\Mercetree\ServiceManager\ServiceManagerConstructorAwareTrait;
use Mateusz\Mercetree\Shop\Currency\Rate\Data\PresenterInterface;
use Mateusz\Mercetree\Shop\Tax\TaxCalculatorInterface;
use Mateusz\Mercetree\Shop\View\PreferencesInterface;

class ShopComponent implements ShopComponentInterface, ServiceManagerConstructorAwareInterface
{
    use ServiceManagerConstructorAwareTrait;

    public function getViewPreferences(): PreferencesInterface
    {
        return $this->serviceManager->get(PreferencesInterface::class);
    }

    public function getCurrencyRateDataPresenter(): PresenterInterface
    {
        return $this->serviceManager->get(PresenterInterface::class);
    }

    public function getTaxCalculator(): TaxCalculatorInterface
    {
        return $this->serviceManager->get(TaxCalculatorInterface::class);
    }

    public function getNumberFormatter(): NumberFormatterInterface
    {
        return $this->serviceManager->get(NumberFormatterInterface::class);
    }
}
