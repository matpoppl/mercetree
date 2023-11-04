<?php

namespace Mateusz\Mercetree\ServiceManager;

use Laminas\ServiceManager\ServiceLocatorInterface;

trait ServiceManagerAwareTrait
{
    protected ServiceLocatorInterface $serviceManager;
    
    public function setServiceManager(ServiceLocatorInterface $serviceManager) : void
    {
        $this->serviceManager = $serviceManager;
    }
}
