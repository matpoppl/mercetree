<?php

namespace Mateusz\Mercetree\Shop;

use Mateusz\Mercetree\Intl\NumberFormatterInterface;
use Mateusz\Mercetree\Shop\Currency\Rate\Data\PresenterInterface;
use Mateusz\Mercetree\Shop\Tax\TaxCalculatorInterface;
use Mateusz\Mercetree\Shop\View\PreferencesInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

interface ShopComponentInterface
{
    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getViewPreferences(): PreferencesInterface;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getCurrencyRateDataPresenter(): PresenterInterface;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getTaxCalculator(): TaxCalculatorInterface;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getNumberFormatter(): NumberFormatterInterface;
}
