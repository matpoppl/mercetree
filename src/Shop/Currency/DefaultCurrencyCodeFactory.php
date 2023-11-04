<?php

namespace Mateusz\Mercetree\Shop\Currency;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;

class DefaultCurrencyCodeFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $options = $options ?: $container->get(ConfigInterface::class)->getArray($requestedName);
        return new $requestedName($options);
    }
}
