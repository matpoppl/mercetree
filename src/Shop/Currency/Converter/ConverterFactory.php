<?php

namespace Mateusz\Mercetree\Shop\Currency\Converter;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\Shop\Currency\CurrencyCodeInterface;
use Mateusz\Mercetree\Shop\Currency\Rate\RateProviderInterface;
use Psr\Container\ContainerInterface;

class ConverterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return new $requestedName($container->get(RateProviderInterface::class), $container->get(CurrencyCodeInterface::class));
    }
}
