<?php

namespace Mateusz\Mercetree;

use Laminas\ServiceManager\ServiceLocatorInterface;
use Mateusz\Mercetree\Application\Component\ComponentManagerInterface;
use Mateusz\Mercetree\ServiceManager\Factory\FileFactory;
use Psr\Container\ContainerExceptionInterface;
use Psr\Container\NotFoundExceptionInterface;

/**
 */
class Application
{
    public function __construct(private readonly ServiceLocatorInterface $serviceManager)
    {}

    /**
     *
     * @template T of object
     * @param string|class-string<T> $id
     * @return mixed|object<T>
     * @throws ContainerExceptionInterface
     * @throws NotFoundExceptionInterface
     */
    public function getService(string $id) : mixed
    {
        return $this->serviceManager->get($id);
    }

    /**
     * @template T of object
     * @param class-string<T> $id
     * @return object<T>
     * @throws \UnexpectedValueException
     */
    public function getComponent(string $id) : object
    {
        try {
            return $this->getService(ComponentManagerInterface::class)->get($id);
        } catch(NotFoundExceptionInterface | ContainerExceptionInterface $ex) {
            throw new \UnexpectedValueException("ComponentManager service retrievable error", 0 , $ex);
        }
    }

    /**
     * @param array<array-key, mixed> $config
     * @return self
     */
    public static function create(array $config) : self
    {
        $sm = FileFactory::createFromOptions($config);
        return new self($sm);
    }
}
