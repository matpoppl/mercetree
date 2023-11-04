<?php

namespace Mateusz\Mercetree\ServiceManager;

use Laminas\ServiceManager\ServiceLocatorInterface;

trait ServiceManagerConstructorAwareTrait
{
    public function __construct(private ServiceLocatorInterface $serviceManager, private ?array $options = null)
    {
    }
}
