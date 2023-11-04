<?php

namespace Mateusz\Mercetree\ServiceManager;

use Laminas\ServiceManager\ServiceLocatorInterface;

interface ServiceManagerAwareInterface
{
    public function setServiceManager(ServiceLocatorInterface $serviceManager) : void;
}
