<?php

namespace Mateusz\Mercetree\Application\Component;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Mateusz\Mercetree\ServiceManager\Factory\FileFactory;
use Mateusz\Mercetree\ServiceManager\FallbackServiceManager;
use Mateusz\Mercetree\ServiceManager\ServiceManagerAwareInterface;
use Mateusz\Mercetree\ServiceManager\ServiceManagerConstructorAwareInterface;
use Mateusz\Mercetree\Shop\ShopComponentInterface;
use Mateusz\Mercetree\TreeConfigurator\TreeConfiguratorComponentInterface;
use Psr\Container\ContainerInterface;

class ComponentFactory implements FactoryInterface
{
    /**
     * @template T of ShopComponentInterface|TreeConfiguratorComponentInterface
     * @param ContainerInterface $container
     * @param class-string<T> $requestedName
     * @param array|null $options
     * @return object<T>
     */
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        if (! class_exists($requestedName)) {
            throw new \UnexpectedValueException("Class `{$requestedName}` don't exists");
        }

        $options = $container->get(ConfigInterface::class)->getArray($requestedName);

        $serviceManager = FileFactory::createFromOptions($options);
        $serviceManager->addAbstractFactory(new FallbackServiceManager($container));

        $smInjectConstructor = is_subclass_of($requestedName, ServiceManagerConstructorAwareInterface::class);
        $smInjectMethod = is_subclass_of($requestedName, ServiceManagerAwareInterface::class);

        if ($smInjectConstructor) {
            return new $requestedName($serviceManager, $options);
        }

        if (! $smInjectMethod) {
            throw new \UnexpectedValueException("Unsupported ServiceManager injection in `{$requestedName}`");
        }

        $component = new $requestedName($options);
        $component->setServiceManager($serviceManager);
        return $component;
    }
}
