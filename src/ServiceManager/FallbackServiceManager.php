<?php

namespace Mateusz\Mercetree\ServiceManager;

use Laminas\ServiceManager\Factory\AbstractFactoryInterface;
use Psr\Container\ContainerInterface;

class FallbackServiceManager implements AbstractFactoryInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {}

    public function canCreate(ContainerInterface $container, $requestedName): bool
    {
        return $this->container->has($requestedName);
    }

    public function __invoke(ContainerInterface $container, $requestedName, ?array $options = null)
    {
        return $this->container->get($requestedName);
    }
}
