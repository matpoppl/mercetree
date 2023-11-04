<?php

namespace Mateusz\Mercetree\Locale;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Locale as IntlLocale;


class EnvDefaltLocaleFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        
        IntlLocale::get
    }
}
