<?php

namespace Mateusz\Mercetree\Shop\Tax;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Psr\Container\ContainerInterface;

class TaxCalculatorFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $options ??= $container->get(ConfigInterface::class)->getArray($requestedName);

        $precision = $options['precision'] ?? null;
        $mode = $options['round_mode'] ?? null;

        return new $requestedName($precision, $mode);
    }
}
