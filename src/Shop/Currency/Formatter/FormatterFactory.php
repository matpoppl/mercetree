<?php

namespace Mateusz\Mercetree\Shop\Currency\Formatter;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Mateusz\Mercetree\Shop\Currency\CurrencyCodeInterface;
use Psr\Container\ContainerInterface;

class FormatterFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $options ??= $container->get(ConfigInterface::class)->getArray($requestedName);
        $locale = $options['locale'] ?? \Locale::getDefault();
        return new $requestedName($container->get(CurrencyCodeInterface::class), $locale);
    }
}
