<?php

namespace Mateusz\Mercetree\Intl;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Psr\Container\ContainerInterface;
use Locale;

class NumberFormatterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $options ??= $container->get(ConfigInterface::class)->getArray($requestedName);

        $locale = $options['locale'] ?? Locale::getDefault();
        $defaultCurrency = $options['default_currency'] ?? null;

        return new $requestedName($defaultCurrency, $locale);
    }
}
