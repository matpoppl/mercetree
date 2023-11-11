<?php

namespace Mateusz\Mercetree\Application\Component;
;
use Psr\Container\ContainerInterface;;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

class ComponentManager implements ComponentManagerInterface
{
    public function __construct(private readonly ContainerInterface $container)
    {}

    public function get(string $id): object
    {
        try {
            return $this->container->get($id);
        } catch (ContainerExceptionInterface | NotFoundExceptionInterface $exception) {
            throw NotFoundException::create("Component `{$id}` not found", $exception);
        }
    }
}
