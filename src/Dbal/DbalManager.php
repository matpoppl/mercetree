<?php

namespace Mateusz\Mercetree\Dbal;

use Mateusz\Mercetree\TreeConfigurator\Data\Dbal\AdapterInterface;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\ContainerInterface;
use Psr\Container\NotFoundExceptionInterface;

class DbalManager implements DbalManagerInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {
    }

    /**
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function get(string $id): AdapterInterface
    {
        return $this->container->get($id);
    }
}
