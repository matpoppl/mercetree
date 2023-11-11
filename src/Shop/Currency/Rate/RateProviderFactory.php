<?php

namespace Mateusz\Mercetree\Shop\Currency\Rate;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Psr\Container\ContainerInterface;

class RateProviderFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $options ??= $container->get(ConfigInterface::class)->getArray($requestedName);

        $sourceCurrencyCode = $options['source_currency_code'];
        $rates = $options['rates'];

        return new $requestedName($sourceCurrencyCode, $rates);
    }
}
