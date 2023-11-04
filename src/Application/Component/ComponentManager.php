<?php

namespace Mateusz\Mercetree\Application\Component;

use Laminas\ServiceManager\ServiceLocatorInterface;

class ComponentManager implements ComponentManagerInterface
{
    public function __construct(private ServiceLocatorInterface $serviceManager)
    {
    }
    
    public function get(string $id): object
    {
        return $this->serviceManager->get($id);
    }
}
