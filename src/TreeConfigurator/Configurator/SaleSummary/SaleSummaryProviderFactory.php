<?php

namespace Mateusz\Mercetree\TreeConfigurator\Configurator\SaleSummary;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\Application\Component\ComponentManagerInterface;
use Mateusz\Mercetree\Shop\ShopComponent;
use Psr\Container\ContainerInterface;

class SaleSummaryProviderFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $shop = $container->get(ComponentManagerInterface::class)->get(ShopComponent::class);
        return new $requestedName($shop->getTaxCalculator());
    }
}
