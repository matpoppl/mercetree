<?php

namespace Mateusz\Mercetree\View\Renderer;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\Intl\Translator\TranslatorInterface;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Psr\Container\ContainerInterface;

class PhtmlRendererFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $options ??= $container->get(ConfigInterface::class)->getArray($requestedName);
        return new $requestedName($container->get(TranslatorInterface::class), $options['paths'] ?? []);
    }
}
