<?php

namespace Mateusz\Mercetree\ServiceManager;

use Laminas\ServiceManager\ServiceManager;
use Laminas\ServiceManager\Factory\FactoryInterface;
use Psr\Container\ContainerInterface;
use Mateusz\Mercetree\ServiceManager\Config\ConfigInterface;
use Mateusz\Mercetree\ServiceManager\Config\Config;

class ServiceManagerFileFactory implements FactoryInterface
{
    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        if (null === $options) {
            $options = $container->get(ConfigInterface::class)->getArray($requestedName);
        }
        
        return self::createFromOptions($options);
    }
    
    public static function createFromFile(string $pathname) : ServiceManager
    {
        if (! is_file($pathname)) {
            throw new \UnexpectedValueException("Config file `{$pathname}` don't exists");
        }
        
        if (! is_readable($pathname)) {
            throw new \UnexpectedValueException("Config file `{$pathname}` is not readable");
        }
        
        $options = require $pathname;
        
        if (! is_array($options)) {
            throw new \UnexpectedValueException("Unsupported options in config file `{$pathname}`");
        }
        
        return self::createFromOptions($options);
    }
    
    public static function createFromOptions(array $options) : ServiceManager
    {
        if (array_key_exists('config_file', $options)) {
            return self::createFromFile($options['config_file']);
        }
        
        $smConfig = [];
        
        if (isset($options['service_manager'])) {
            
            $smConfig = $options['service_manager'];
            
            if (! is_array($smConfig)) {
                throw new \UnexpectedValueException('Expecting ServiceManager options array');
            }
            
            unset($options['service_manager']);
        } else {
            $smConfig = $options;
        }
        
        $sm = new ServiceManager($smConfig);
        $sm->setService(ConfigInterface::class, new Config($options));
        return $sm;
    }
}
