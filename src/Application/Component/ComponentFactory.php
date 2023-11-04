<?php

namespace Mateusz\Mercetree\Application\Component;

use Laminas\ServiceManager\Factory\FactoryInterface;
use Mateusz\Mercetree\ServiceManager\ServiceManagerAwareInterface;
use Mateusz\Mercetree\ServiceManager\ServiceManagerConstructorAwareInterface;
use Mateusz\Mercetree\ServiceManager\ServiceManagerFileFactory;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Psr\Container\ContainerInterface;

class ComponentFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        if (! class_exists($requestedName)) {
            throw new \UnexpectedValueException("Class `{$requestedName}` don't exists");
        }
        
        $options = $container->get(ConfigInterface::class)->getArray($requestedName);
        
        $serviceManager = ServiceManagerFileFactory::createFromOptions($options);
        
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
