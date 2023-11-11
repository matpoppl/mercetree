<?php

namespace Mateusz\Mercetree\ServiceManager;

use Laminas\ServiceManager\ServiceLocatorInterface;

trait ServiceManagerConstructorAwareTrait
{
    public function __construct(private readonly ServiceLocatorInterface $serviceManager, private readonly ?array $options = null)
    {
    }
}
