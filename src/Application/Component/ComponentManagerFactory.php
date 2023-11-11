<?php

namespace Mateusz\Mercetree\Application\Component;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Mateusz\Mercetree\ServiceManager\Factory\FileFactory;
use Mateusz\Mercetree\ServiceManager\FallbackServiceManager;
use Psr\Container\ContainerInterface;

class ComponentManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null) : object
    {
        if (!class_exists($requestedName)) {
            throw new \UnexpectedValueException("Class `{$requestedName}` don't exists");
        }

        $options ??= $container->get(ConfigInterface::class)->getArray($requestedName);

        $serviceManager = FileFactory::createFromOptions($options);
        $serviceManager->addAbstractFactory(new FallbackServiceManager($container));
        return new $requestedName($serviceManager);
    }
}
