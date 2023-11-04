<?php

namespace Mateusz\Mercetree\Application\Component;

use Laminas\ServiceManager\ServiceManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Laminas\ServiceManager\Factory\InvokableFactory;
use Mateusz\Mercetree\ServiceManager\Config\Config;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Psr\Container\ContainerInterface;

class ComponentManagerFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        if (! class_exists($requestedName)) {
            throw new \UnexpectedValueException("Class `{$requestedName}` don't exists");
        }
        
        $options = $container->get(ConfigInterface::class)->getArray($requestedName);
        
        if (array_key_exists('components', $options)) {
            $components = $options['components'];
            unset($options['components']);
            
            if (! is_array($components)) {
                throw new \UnexpectedValueException('Components config array required');
            }
            
        } else {
            $components = [] ;
        }
        
        $factories = [];
        
        foreach ($components as $id => $factory) {
            if (is_string($id)) {
                $factories[$id] = $factory;
            } else {
                $factories[$factory] = InvokableFactory::class;
            }
        }
        
        $serviceManager = new ServiceManager([
            'factories' => $factories,
        ]);
        
        $serviceManager->setService(ConfigInterface::class, new Config($options));
        
        return new $requestedName($serviceManager);
    }
}
