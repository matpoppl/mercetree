<?php

namespace Mateusz\Mercetree\Shop;

use Mateusz\Mercetree\Shop\Currency\Converter\CurrencyConverterInterface;
use Mateusz\Mercetree\Shop\Currency\Formatter\CurrencyFormatterInterface;
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
    public function getTaxCalculator(): TaxCalculatorInterface;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getCurrencyConverter(): CurrencyConverterInterface;

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getCurrencyFormatter(): CurrencyFormatterInterface;
}
