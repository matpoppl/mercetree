<?php

namespace Mateusz\Mercetree\ServiceManager;

use Laminas\ServiceManager\ServiceLocatorInterface;

interface ServiceManagerConstructorAwareInterface
{
    public function __construct(ServiceLocatorInterface $serviceManager, ?array $options = null);
}
