<?php

namespace Mateusz\Mercetree\Dbal;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Mateusz\Mercetree\ServiceManager\Factory\FileFactory;
use Mateusz\Mercetree\ServiceManager\FallbackServiceManager;
use Psr\Container\ContainerInterface;

class DbalManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        $options ??= $container->get(ConfigInterface::class)->getArray($requestedName);

        if (!class_exists($requestedName)) {
            $requestedName = DbalManager::class;
        }

        $serviceManager = FileFactory::createFromOptions($options);
        $serviceManager->addAbstractFactory(new FallbackServiceManager($container));
        return new $requestedName($serviceManager, $options);
    }
}
