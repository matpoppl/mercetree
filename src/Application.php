<?php

namespace Mateusz\Mercetree;

use Laminas\ServiceManager\ServiceLocatorInterface;
use Mateusz\Mercetree\ServiceManager\ServiceManagerFileFactory;
use Mateusz\Mercetree\Application\Component\ComponentManagerInterface;

class Application
{
    public function __construct(private ServiceLocatorInterface $serviceManager)
    {}
    
    public function getService(string $id) : mixed
    {
        return $this->serviceManager->get($id);
    }
    
    /**
     * @template T
     * @param class-string<T> $id
     * @return object T
     */
    public function getComponent(string $id) : object
    {
        return $this->getService(ComponentManagerInterface::class)->get($id);
    }
    
    public static function create(array $config) : self
    {
        $sm = ServiceManagerFileFactory::createFromOptions($config);
        return new self($sm);
    }
}
