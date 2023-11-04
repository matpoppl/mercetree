<?php

namespace Mateusz\Mercetree\Shop\View;

use Psr\Container\ContainerInterface;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\Shop\Currency\CurrencyCodeAwareInterface;
use Mateusz\Mercetree\Shop\Currency\CurrencyCodeInterface;

class PreferencesFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        if (! class_exists($requestedName)) {
            $requestedName = Preferences::class;
        }

        $preferences = new $requestedName();
        
        if ($preferences instanceof CurrencyCodeAwareInterface) {
            $preferences->setCurrencyCode($container->get(CurrencyCodeInterface::class));
        }
        
        return $preferences;
    }
}
